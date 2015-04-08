<?php
namespace mhdev\MhDirectory\Controller;

class BackendController 
	extends ActionController {

	// TypoScript settings
    protected $settings = array();
    // id of selected page
    protected $id;
    // info of selected page
    protected $pageinfo;


	/**
	 * backendRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\BackendRepository
	 * @inject
	 */
	protected $backendRepository;


	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface
	 * @inject
	 */
	protected $persistenceManager;
 
    public function initializeAction() {
        $this->id 				= (int)\TYPO3\CMS\Core\Utility\GeneralUtility::_GP('id');
        $this->pageinfo 		= \TYPO3\CMS\Backend\Utility\BackendUtility::readPageAccess($this->id, $GLOBALS['BE_USER']->getPagePermsClause(1));
        $configurationManager 	= \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Configuration\\BackendConfigurationManager');
 
        $this->settings = $configurationManager->getConfiguration(
            $this->request->getControllerExtensionName(),
            $this->request->getPluginName()
        );

        $vars = \TYPO3\CMS\Core\Utility\GeneralUtility::_GET('tx_mhdirectory_user_mhdirectorymanagement');
        $lastActionMenuItem = $GLOBALS['BE_USER']->uc['tx_mhdirectory']['lastActionMenuItem'];

        if(!$vars['action'] && $lastActionMenuItem) {
            self::saveState();
            $this->redirect($lastActionMenuItem);
        }

        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
		$querySettings->setRespectStoragePage(FALSE);
        $querySettings->setStoragePageIds(array());
        $this->entryRepository->setDefaultQuerySettings($querySettings);
    }


	public function indexAction() {
		self::saveState('index');

        $oEntriesView 			= $this->entryRepository->getStats('count_views');
        $oEntriesClicks 		= $this->entryRepository->getStats('count_clicks');
        $oEntriesLink 			= $this->entryRepository->getStats('count_link');
        $oEntriesTwitter 		= $this->entryRepository->getStats('count_twitter');
        $oEntriesFacebook 		= $this->entryRepository->getStats('count_facebook');

        $this->view->assign('views', $oEntriesView);
        $this->view->assign('clicks', $oEntriesClicks);
        $this->view->assign('links', $oEntriesLink);
        $this->view->assign('twitter', $oEntriesTwitter);
        $this->view->assign('facebook', $oEntriesFacebook);
	}

	public function importAction() {
		self::saveState('import');

		$bValid 		= false;
		$aOutput 		= array();
		$aTables 		= array();
		$aImportOutput 	= array();
		$oTables 		= $this->backendRepository->checkOldTables();
		

		if(count($oTables) > 0) {
			$bValid = true;
			foreach($oTables AS $aTable) {
				foreach($aTable AS $sKey => $sTable) {
					if($sTable == 'tx_mhbranchenbuch_ip') continue;
					$oCount = $this->backendRepository->getCountFromOldTable($sTable);
					$aOutput[]	= array(
						'name' => $sTable,
						'count' => $oCount[0]['total']
					);
					$aTables[$sTable] = $oCount[0]['total'];
				}
			}

			$oLastActive = $this->backendRepository->getLastActive();
			if(count($oLastActive) == 0) {
				$oImportModel = new \mhdev\MhDirectory\Domain\Model\Backend;
				$oImportModel->setImportStatus('created');
				$this->backendRepository->add($oImportModel);
			}
		}

		$oImports	= $this->backendRepository->findAll();

		if(!$bValid)
			$this->flashMessageContainer->add(
	            'Can\'t find the database tables "tx_mhbranchenbuch_*", no import possible.',
	            null,
	            \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
	        );

		$this->view->assign('valid', $bValid);
		$this->view->assign('imports', $oImports);
		$this->view->assign('result', $aOutput);

		// request startet?
		$aPost 			= \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('tx_mhdirectory_user_mhdirectorymanagement');
		$iStoragePid 	= (int)$aPost['import']['storagePid'];
		if($iStoragePid > 0) {
			if($this->request->hasArgument('preview')) {
				$aImportOutput = $this->import(true, $aTables, $iStoragePid);
			} elseif($this->request->hasArgument('submit')) {
				$aImportOutput = $this->import(false, $aTables, $iStoragePid);
			}
		} else if($this->request->hasArgument('preview') OR $this->request->hasArgument('submit')){
			$this->flashMessageContainer->add(
	            'Please set the "storagePid" to a valid value!',
	            null,
	            \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
	        );
		}

		$this->view->assign('preview', $this->request->hasArgument('preview'));
		$this->view->assign('importResult', $aImportOutput);
	}

	private function import($bPreview = false, $aTablesToImport, $iStoragePid) {
		$aRelations = array();
		$bSkipFederal = false;
		$bSkipAdministrative = false;
		$bSkipCities = false;

		$aOutput = array(
			'status' 	=> 'start', 
			'preview' 	=> $bPreview,
			'error'		=> array(),
			'result'	=> array()
		);

		$oLastActive = $this->backendRepository->getLastActive();

		if($oLastActive) {
			$aRelationsFederal 	= (array)unserialize($oLastActive->getRelationsFederal());
			$aRelationsDistrict = (array)unserialize($oLastActive->getRelationsAdministrative());
			$aRelationsCities 	= (array)unserialize($oLastActive->getRelationsCities());


			if(count($aTablesToImport) > 0) {
				if(!isset($aTablesToImport['tx_mhbranchenbuch_bundesland']) OR (int)$aTablesToImport['tx_mhbranchenbuch_bundesland'] == 0)
					$bSkipFederal = true;

				if(!$bSkipFederal) {
					if(!isset($aTablesToImport['tx_mhbranchenbuch_landkreis']) OR (int)$aTablesToImport['tx_mhbranchenbuch_landkreis'] == 0)
						$bSkipAdministrative = true;

					if(!$bSkipAdministrative) {
						if(!isset($aTablesToImport['tx_mhbranchenbuch_ort']) OR (int)$aTablesToImport['tx_mhbranchenbuch_ort'] == 0)
							$bSkipCities = true;

						if(!$bSkipCities) {
							// import federal states
								// check if a import in the past was successfull and skip this step
							if(!isset($aRelationsFederal['__status']) && $aRelationsFederal['__status'] != 'finish') {
								$aOutput['status'] = 'import_federal_start';
								$oFederal = $this->backendRepository->getRows('tx_mhbranchenbuch_bundesland');
								foreach($oFederal AS $iIndex => $aRow) {
									// temporary index (for preview)
									$iNewUid = 'f_' . ($iIndex + 1);
									if(!$bPreview) {
										$oStateModel = new \mhdev\MhDirectory\Domain\Model\State;
										$oStateModel->setName($aRow['name']);
										$oStateModel->setPid($iStoragePid);
										$oStateModel->setMapLng($aRow['map_lng']);
										$oStateModel->setMapLat($aRow['map_lat']);
										$this->stateRepository->add($oStateModel);
										$this->persistenceManager->persistAll();
										$iNewUid = $oStateModel->getUid();
									}
									// collect relations
									$aRelations['federal_states'][$aRow['uid']] = array(
										'name' 		=> $aRow['name'], 
										'new_uid'	=> $iNewUid
									);
								}
								// set status
								$aRelations['federal_states']['__status'] = 'finish';
								$oLastActive->setRelationsFederal(serialize($aRelations['federal_states']));
								// update repo
								$this->backendRepository->update($oLastActive);
								// set import status
								$aOutput['status'] = 'import_federal_done';
							} else {
								// get from database
								$aRelations['federal_states'] = $aRelationsFederal;
							}


							// import administrative districts
							if(!isset($aRelationsDistrict['__status']) && $aRelationsDistrict['__status'] != 'finish') {
								$aOutput['status'] = 'import_districts_start';
								$oDistricts = $this->backendRepository->getRows('tx_mhbranchenbuch_landkreis');
								foreach($oDistricts AS $iIndex => $aRow) {
									$iNewUid 			= 'a_' . ($iIndex + 1);
									$iRelationFederal 	= isset($aRelations['federal_states'][(int)$aRow['bundesland']]) ? $aRelations['federal_states'][(int)$aRow['bundesland']]['new_uid'] : 0;
									$oRelationFederal	= $this->stateRepository->findByUid($iRelationFederal);
									if(!$bPreview) {
										$oDistrictModel = new \mhdev\MhDirectory\Domain\Model\District;
										$oDistrictModel->setName($aRow['name']);
										$oDistrictModel->setRelationState($oRelationFederal);
										$oDistrictModel->setPid($iStoragePid);
										$oDistrictModel->setMapLng($aRow['map_lng']);
										$oDistrictModel->setMapLat($aRow['map_lat']);
										$oDistrictModel->setDescription($aRow['detail']);
										$this->districtRepository->add($oDistrictModel);
										$this->persistenceManager->persistAll();
										$iNewUid = $oDistrictModel->getUid();
									}
									$aRelations['administrative_districts'][$aRow['uid']] = array(
										'name' 				=> $aRow['name'], 
										'relation_federal'	=> $iRelationFederal,
										'new_uid'			=> $iNewUid
									);
								}
								$aRelations['administrative_districts']['__status'] = 'finish';
								$oLastActive->setRelationsAdministrative(serialize($aRelations['administrative_districts']));
								$this->backendRepository->update($oLastActive);
								$aOutput['status'] = 'import_districts_done';
							} else {
								$aRelations['administrative_districts'] = $aRelationsDistrict;
							}

							// import cities
							if(!isset($aRelationsCities['__status']) && $aRelationsCities['__status'] != 'finish') {
								$aOutput['status'] = 'import_cities_start';
								$oCities = $this->backendRepository->getRows('tx_mhbranchenbuch_ort');
								foreach($oCities AS $iIndex => $aRow) {
									$iNewUid 					= 'c_' . ($iIndex + 1);
									$iRelationAdministrative 	= isset($aRelations['administrative_districts'][(int)$aRow['landkreis']]) ? $aRelations['administrative_districts'][(int)$aRow['landkreis']]['new_uid'] : 0;
									$oRelationAdministrative 	= $this->districtRepository->findByUid($iRelationAdministrative);
									if(!$bPreview) {
										$oCityModel = new \mhdev\MhDirectory\Domain\Model\City;
										$oCityModel->setName($aRow['name']);
										$oCityModel->setRelationDistrict($oRelationAdministrative);
										$oCityModel->setPid($iStoragePid);
										$oCityModel->setMapLng($aRow['map_lng']);
										$oCityModel->setMapLat($aRow['map_lat']);
										$oCityModel->setDescription($aRow['detail']);
										$this->cityRepository->add($oCityModel);
										$this->persistenceManager->persistAll();
										$iNewUid = $oCityModel->getUid();
									}
									$aRelations['cities'][$aRow['uid']] = array(
										'name' 				=> $aRow['name'], 
										'relation_district'	=> $iRelationAdministrative,
										'new_uid'			=> $iNewUid
									);
								}
								$aRelations['cities']['__status'] = 'finish';
								$oLastActive->setRelationsCities(serialize($aRelations['cities']));
								$this->backendRepository->update($oLastActive);
								$aOutput['status'] = 'import_cities_done';
							} else {
								$aRelations['cities'] = $aRelationsCities;
							}
						}
					}
				}

				// import entries
				$aOutput['status'] 	= 'import_entries_start';
				$oCompanies = $this->backendRepository->getRows('tx_mhbranchenbuch_firmen');
				foreach($oCompanies AS $iIndex => $aRow) {
					$iNewUid 					= 'e_' . ($iIndex + 1);
					$iRelationFederal 			= isset($aRelations['federal_states'][(int)$aRow['bundesland']]) ? $aRelations['federal_states'][(int)$aRow['bundesland']]['new_uid'] : 0;
					$iRelationAdministrative 	= isset($aRelations['administrative_districts'][(int)$aRow['landkreis']]) ? $aRelations['administrative_districts'][(int)$aRow['landkreis']]['new_uid'] : 0;
					$iRelationCity 				= isset($aRelations['cities'][(int)$aRow['ort']]) ? $aRelations['cities'][(int)$aRow['ort']]['new_uid'] : 0;
					
					$oRelationFederal			= $this->stateRepository->findByUid($iRelationFederal);
					$oRelationAdministrative 	= $this->districtRepository->findByUid($iRelationAdministrative);
					$oRelationCity 				= $this->cityRepository->findByUid($iRelationCity);

					if(!$bPreview) {
						$iNewUid = 0;
						$oEntriesModel = new \mhdev\MhDirectory\Domain\Model\Entries;
						
						if($oRelationFederal)
							$oEntriesModel->setRelationState($oRelationFederal);
						
						if($oRelationAdministrative)
							$oEntriesModel->setRelationDistrict($oRelationAdministrative);
						
						if($oRelationCity) 
							$oEntriesModel->setRelationCity($oRelationCity);

						$oEntriesModel->setPid($iStoragePid);
						$oEntriesModel->setCompany($aRow['firma']);
						$oEntriesModel->setNameIntern($aRow['firma']);
						$oEntriesModel->setForename($aRow['forename']);
						$oEntriesModel->setLastname($aRow['lastname']);
						$oEntriesModel->setZip($aRow['zip']);
						$oEntriesModel->setCity($aRow['city']);
						$oEntriesModel->setAddress($aRow['adresse']);
						$oEntriesModel->setPhone($aRow['telefon']);
						$oEntriesModel->setFax($aRow['fax']);
						$oEntriesModel->setLink($aRow['link']);
						$oEntriesModel->setMail($aRow['email']);
						$oEntriesModel->setCustom1($aRow['custom1']);
						$oEntriesModel->setCustom2($aRow['custom2']);
						$oEntriesModel->setCustom3($aRow['custom3']);
						$oEntriesModel->setMapLng($aRow['map_lng']);
						$oEntriesModel->setMapLat($aRow['map_lat']);
						$oEntriesModel->setDescription($aRow['detail']);
						$this->entryRepository->add($oEntriesModel);
						$this->persistenceManager->persistAll();
						$iNewUid = $oEntriesModel->getUid();
					}

					$aRelations['companies'][$aRow['uid']] = array(
						'name' 				=> $aRow['firma'], 
						'relation_federal'	=> $iRelationFederal,
						'relation_district'	=> $iRelationAdministrative,
						'relation_city'		=> $iRelationCity,
						'new_uid'			=> $iNewUid
					);
				}
				$aRelations['companies']['__status'] = 'finish';
				$oLastActive->setRelationsEntries(serialize($aRelations['companies']));
				$this->backendRepository->update($oLastActive);
				$aOutput['status'] = 'import_entries_done';

				$aOutput['result']	= $aRelations;

				if(!$bPreview) {

					$this->flashMessageContainer->add(
			            'Import successfull!',
			            null,
			            \TYPO3\CMS\Core\Messaging\FlashMessage::OK
			        );

					$oLastActive->setFinished(1);
					$oLastActive->setImportStatus('done');
					$this->backendRepository->update($oLastActive);
				}
			} else {
				$this->flashMessageContainer->add(
		            'There are no valid tables in the database to import from!',
		            null,
		            \TYPO3\CMS\Core\Messaging\FlashMessage::ERROR
		        );
				$aOutput['status'] = 'fail';
				$aOutput['error'][] = 'missing tables';
			}
		} else {
			$aOutput['status'] = 'fail';
			$aOutput['error'][] = 'missing database row';
		}

		return $aOutput;
	}


	 /**
     * Save the selected menu item
     *
     * @param string $actionMenuItem
     * @return void
     */
    protected static function saveState($actionMenuItem = '') {
        $GLOBALS['BE_USER']->uc['tx_mhdirectory']['lastActionMenuItem'] = $actionMenuItem;
        $GLOBALS['BE_USER']->writeUC();
    }

}



?>