<?php
namespace mhdev\MhDirectory\Domain\Repository;

class DistrictRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * Get all districts by state id
     *
     * @param int $iStateUid
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function findByState($iStateUid) {
		$query 	= $this->createQuery();

		$query->matching(
			$query->equals('relation_state', (int)$iStateUid)
		);

		return $query->execute();
	}	
}
