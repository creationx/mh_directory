<?php
namespace mhdev\MhDirectory\Controller;

class ActionController 
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


	/**
	 * categoriesRepository
	 *
	 * @var \mhdev\MhDirectory\Domain\Repository\CategoriesRepository
	 * @inject
	 */
	protected $categoriesRepository;

	public function initializeAction() {
		$this->contentObj = $this->configurationManager->getContentObject();
	}

	public function detailAction() {
		$aRequest		= $this->request->getArguments();
		$iUid 			= (int)$aRequest['uid'];
		$aOutput 		= array();
		$sImgDir		= PATH_site . '/uploads/tx_mhdirectory/';

		$oEntry			= $this->entryRepository->findByUid($iUid);

		if($aRequest['controller'] == 'Alphabetical') {
			$sKey 		= $this->settings['alphabetical_index'];
			$aValidKeys	= array('company', 'name_intern', 'city', 'custom1', 'custom2', 'custom3');
			if(!in_array($sKey, $aValidKeys)) $sKey = 'company';

			switch ($sKey) {
				case 'company':
					$sChar = $oEntry->getCompany()[0];
					break;
				case 'name_intern':
					$sChar = $oEntry->getNameIntern()[0];
					break;
			}
		}


		$sIpAdress	= $_SERVER['REMOTE_ADDR'];
		$aLastCalls	= (array)unserialize($oEntry->getLastCalls());

		if(isset($aLastCalls['main'])) {
			if(!in_array($sIpAdress, $aLastCalls['main'])) {
				$oEntry->setCountClicks(($oEntry->getCountClicks+1));
				$aLastCalls['main'][]	= $_SERVER['REMOTE_ADDR'];
				if(count($aLastCalls) > 30) unset($aLastCalls['main'][(count($aLastCalls)-1)]);
				$oEntry->setLastCalls(serialize($aLastCalls));
			}
		} else {
			$aLastCalls['main'][]	= $_SERVER['REMOTE_ADDR'];
			$oEntry->setLastCalls(serialize($aLastCalls));
		}

		$oEntry->setCountViews(($oEntry->getCountViews() + 1));

		$this->entryRepository->update($oEntry);

		if($oEntry) {
			$aBreadcrumb = array();
			if($aRequest['controller'] == 'List') {
				$aBreadcrumb		= $this->getBreadcrumb(4, $iUid);
			} elseif($aRequest['controller'] == 'Category') {
				$aBreadcrumb		= $this->getBreadcrumb($aRequest);
			}

			$this->view->assign('breadcrumb', $aBreadcrumb);
			$this->view->assign('ref', $sChar);
			$this->view->assign('result', $oEntry);
		}

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		$this->view->assign('request', $aRequest);
	}


	/**
	*	Generate Array for Google Map POI's
	*	@param object $oEntries
	*	@return string json encoded array
	*/
	public function generateGMapPois($oEntries) {
		$aLocations = array();
		if(count($oEntries) > 0) {
			foreach($oEntries AS $oEntry) {
				$oType = $oEntry->getRelationType();
				if(count($oType) == 0) continue;

				$aOptions = $this->getTypeOptions($oType->getOptions());
				if(!in_array('map', $aOptions)) continue;

				$aLocations[] = array(
					"" . $oEntry->getCompany() . "",
					$oEntry->getMapLat(),
					$oEntry->getMapLng()
				);
			}
		}

		return json_encode($aLocations);
	}

	/**
	* 	Get type from options (bitwise operation)
	* 	@param int $iValue
	*	@return array options
	*/
	public function getTypeOptions($iValue) {
		$aOptions 	= array(
			0 => "detail",
			1 => "image",
			2 => "twitter", 
			3 => "facebook", 
			4 => "description", 
			5 => "map", 
			6 => "mail", 
			7 => "link",
			8 => "address",
			9 => "contact",
			10 => "custom1",
			11 => "custom2",
			12 => "custom3",
			13 => "opening",
			14 => "xing",
			15 => "linkedin",
			16 => "twitter_timeline"
		);
		$aOutput 	= array();
		for ($i=0; $i<(count($aOptions)-1); $i++) {
			if (($iValue >> $i) & 1) {
				$aOutput[] = $aOptions[$i];
			}
		}
		return $aOutput;
	}



	/**
	*	Prepare filter for quering entries
	*	@param array override settings
	*	@return array filter options
	*/
	public function getFilter($aSettings = array()) {
		$aFilter = array();

		// collect categories
		$aSettingsCategories = $this->settings['categories'];
		if(count($aSettings) > 0 && isset($aSettings['categories']))
			$aSettingsCategories = $aSettings['categories'];

		$aEntriesByCategories = array();
		if(isset($aSettingsCategories) && strlen($aSettingsCategories) > 0) {
			$aCategories 	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $aSettingsCategories);
			if(count($aCategories) > 0) {
				foreach($aCategories AS $iCat) {
					$oSubCategories	= $this->categoriesRepository->findByParent($iCat);
					if($oSubCategories) {
						foreach($oSubCategories AS $oSubCat) {
							$aCategories[] = (int)$oSubCat->getUid();
						}
					}
				}
				$aEntriesByCategories = $this->entryRepository->findByCategories($aCategories);
				$aFilter['categories']	= $aEntriesByCategories;
			}
		}

		$sTypesToDisplay = $this->settings['types_to_display'];
		if(strlen($sTypesToDisplay) > 0) 
			$aFilter['typesToDisplay'] = $sTypesToDisplay;
		

		$sOrderBy		= $this->settings['orderby'];
		if(strlen($sOrderBy) > 0) 
			$aFilter['orderby'] = $sOrderBy;

		return $aFilter;
	}


	public function mailAction() {
		$aRequest			= $this->request->getArguments();
		$iUid 				= (int)$aRequest['uid'];
		$aPost				= \TYPO3\CMS\Core\Utility\GeneralUtility::_POST('tx_mhdirectory_pi1');
		$aRequiredFields	= \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['list_mail_required']);
		$aError 			= array();
		$bRecaptcha 		= false;

		// recaptcha-support
		if($this->settings['recaptcha'] == 1 && ($this->settings['recaptcha_public'] != '' && $this->settings['recaptcha_private'] != '')) {
			$this->response->addAdditionalHeaderData('<script src="https://www.google.com/recaptcha/api.js"></script>');
			$bRecaptcha = true;
		}
		
		/** @var $logger \TYPO3\CMS\Core\Log\Logger */
		$logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);

		if($iUid > 0) {
			$oEntry			= $this->entryRepository->findByUid($iUid);
			if(strlen($oEntry->getMail()) != '' && \TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($oEntry->getMail())) {
				if(count($aPost) > 0) {
					foreach($aPost AS $sKey => $sValue) {
						if($sKey == '__referrer' OR $sKey == '__trustedProperties') continue;
						
						$bValid = true;
						if(in_array($sKey, $aRequiredFields) && strlen($sValue) == 0) $bValid = false;
						if($sKey == 'list_form_mail' && (strlen($sValue) > 0 && !\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($sValue))) $bValid = false;

						if(!$bValid) {
							$aError[] = $sKey;
						} else {
							$sMailMessage .= \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($sKey, 'mh_directory') . ": " . trim(htmlentities($sValue)) . "\n\n";
						}
					}

					// validate recaptcha
					if($bRecaptcha) {
						$sGResponse = $_POST['g-recaptcha-response'];

						$sGUrl = 'https://www.google.com/recaptcha/api/siteverify';
						$aGData = array(
							'secret' 	=> $this->settings['recaptcha_private'],
							'response' 	=> $sGResponse,
							'remoteip'	=> $_SERVER['remote_addr']
						);

						$oGContext  = stream_context_create(array('http' => array('method' => 'POST', 'content' => http_build_query($aGData))));
						$aGResult 	= (array)json_decode(file_get_contents($sGUrl, false, $oGContext));

						if(!$aGResult['success'])
							$aError[] = 'list_form_recaptcha';
					}

					if(count($aError) == 0 ) {
						$message = (new \TYPO3\CMS\Core\Mail\MailMessage())
						->setFrom(array($aPost['list_form_mail']))
						->setTo($oEntry->getMail())
						->setSubject(\TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('list_mail_subject', 'mh_directory'))
						->setBody($sMailMessage);
					
						$message->send();

						if($message->isSent()) {
							$aError['status'] = 'done';
							$logger->info('Mail send to ' . $oEntry->getCompany());
						} else {
							$logger->error('Error sending Mail to ' . $oEntry->getCompany());
						}
					}
				}
			}

			if(!isset($aError['status'])) $aError['status'] = 'nothing';

			$aBreadcrumb = array();
			if($aRequest['controller'] == 'List') {
				$aBreadcrumb		= $this->getBreadcrumb(4, $iUid);
			} elseif($aRequest['controller'] == 'Category') {
				$aBreadcrumb		= $this->getBreadcrumb($aRequest);
			}

			$this->view->assign('breadcrumb', $aBreadcrumb);
			$this->view->assign('recaptcha', $bRecaptcha);
			$this->view->assign('entry', $oEntry);
		}


		$this->view->assign('uid', $iUid);
		$this->view->assign('post', $aPost);
		$this->view->assign('error', $aError);
		$this->view->assign('required', $aRequiredFields);
		$this->view->assign('request', $aRequest);
	}
}