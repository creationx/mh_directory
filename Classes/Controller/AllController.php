<?php
namespace mhdev\MhDirectory\Controller;

class AllController 
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
		$aResults	= $this->entryRepository->findAll();

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		$this->view->assign('result', $aResults);
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
}