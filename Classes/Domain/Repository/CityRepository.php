<?php
namespace mhdev\MhDirectory\Domain\Repository;

class CityRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * Get all cities by district id
     *
     * @param int $iDistrictUid
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function findByDistrict($iDistrictUid) {
		$query 	= $this->createQuery();

		$query->matching(
			$query->equals('relation_district', (int)$iDistrictUid)
		);

		return $query->execute();
	}	
}
