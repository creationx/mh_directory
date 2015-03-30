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

	}
}