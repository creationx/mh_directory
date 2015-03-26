<?php
namespace mhdev\MhDirectory\Controller;

class ListController 
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	public $contentObj;

	/**
	 * entryRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\EntriesRepository
	 * @inject
	 */
	protected $entryRepository;

	/**
	 * stateRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\StateRepository
	 * @inject
	 */
	protected $stateRepository;

	/**
	 * districtRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\DistrictRepository
	 * @inject
	 */
	protected $districtRepository;

	/**
	 * cityRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\CityRepository
	 * @inject
	 */
	protected $cityRepository;

	public function initializeAction() {
		$this->contentObj = $this->configurationManager->getContentObject();
	}

	public function indexAction() {
		$aRequest		= $this->request->getArguments();
		$iStateUid 		= (int)$aRequest['state'];
		$iDistrictUid 	= (int)$aRequest['district'];
		$iCityUid 		= (int)$aRequest['city'];
		$iStatus 		= 0;
		$iMap 			= 0;

		// \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($aRequest);

		$aOutput			= array();

		if($iCityUid > 0) {
			$oResStates 		= $this->entryRepository->findByRelationCity($iCityUid);
		} else if($iDistrictUid > 0) {
			$iStatus 			= 2;
			$oResStates 		= $this->cityRepository->findByDistrict($iDistrictUid);
		} else if($iStateUid > 0) {
			$iStatus 			= 1;
			$oResStates 		= $this->districtRepository->findByState($iStateUid);
		} else {
			$oResStates 		= $this->stateRepository->findAll();
		}

		if($iCityUid == 0) {
			if(count($oResStates) > 0) {
				foreach($oResStates AS $oState) {
					$iNumberOfEntries = 0;
					if($this->settings['list_show_number_of_entries'] == 1) {
						$iNumberOfEntries 	= (int)$this->entryRepository->findByLocation((int)$oState->getUid());
					}

					if($this->settings['list_hide_empty'] == 1 && $iNumberOfEntries == 0)
						continue; 

					$aOutput[]	= array(
						'uid'	=> $oState->getUid(),
						'name'	=> $oState->getName(),
						'number_of_entries'	=> $iNumberOfEntries
					);
				}
			}
		} else {
			if(count($oResStates) > 0) {
				$aOutput 	= $oResStates;
				$iStatus	= 3;
				$iMap 		= 1;
			}
		}

		
		$this->view->assign('map', $iMap);
		$this->view->assign('status', $iStatus);
		$this->view->assign('state', $iStateUid);
		$this->view->assign('district', $iDistrictUid);
		$this->view->assign('city', $iCityUid);
		$this->view->assign('result', $aOutput);
	}

	public function detailAction() {
		$aRequest		= $this->request->getArguments();
		$iUid 			= (int)$aRequest['uid'];
		$aOutput 		= array();

		$oEntry			= $this->entryRepository->findByUid($iUid);

		#if($oEntry) {

		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($aRequest);
	}

	public function outAction() {
		$aRequest		= $this->request->getArguments();
		$iUid 			= (int)$aRequest['uid'];
		$sKey 			= $aRequest['key'];
		$aOutput 		= array();

		$oEntry			= $this->entryRepository->findByUid($iUid);

		if($oEntry) {
			switch ($sKey) {
				case 'link':
					$aOutput['link']	= $oEntry->getLink();
					break;
				case 'twitter':
					$aOutput['link']	= 'http://twitter.com/' . $oEntry->getTwitter();
					break;
				case 'facebook':
					$aOutput['link']	= 'http://facebook.com/' . $oEntry->getFacebook();
			}
		}

		// @TODO count clicks for stats

		$this->view->assign('result', $aOutput);
	}

	public function mailAction() {
		$aRequest			= $this->request->getArguments();
		$aRequiredFields	= explode(',', $this->settings['list_mail_required']);

		\TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($aRequiredFields);

		$this->view->assign('required', $aRequiredFields);
		$this->view->assign('requiredjs', json_encode($aRequiredFields));

	}

}



?>