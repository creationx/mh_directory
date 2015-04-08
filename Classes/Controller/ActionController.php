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

	public function initializeAction() {
		$this->contentObj = $this->configurationManager->getContentObject();
	}

	public function detailAction() {
		$aRequest		= $this->request->getArguments();
		$iUid 			= (int)$aRequest['uid'];
		$aOutput 		= array();

		$oEntry			= $this->entryRepository->findByUid($iUid);

		$sIpAdress	= $_SERVER['REMOTE_ADDR'];
		$aLastCalls	= (array)unserialize($oEntry->getLastCalls());

		if(!in_array($sIpAdress, $aLastCalls['main'])) {
			$oEntry->setCountClicks(($oEntry->getCountClicks+1));
			$aLastCalls['main'][]	= $_SERVER['REMOTE_ADDR'];
			if(count($aLastCalls) > 30) unset($aLastCalls['main'][(count($aLastCalls)-1)]);
			$oEntry->setLastCalls(serialize($aLastCalls));
		}

		$oEntry->setCountViews(($oEntry->getCountViews() + 1));

		$this->entryRepository->update($oEntry);

		if($oEntry) {
			$this->view->assign('result', $oEntry);
		}

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');
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
			13 => "opening"
		);
		$aOutput 	= array();
		for ($i=0; $i<(count($aOptions)-1); $i++) {
			if (($iValue >> $i) & 1) {
				$aOutput[] = $aOptions[$i];
			}
		}
		return $aOutput;
	}
}