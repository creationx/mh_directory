<?php
namespace mhdev\MhDirectory\Domain\Repository;

class EntriesRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

    /**
     * Get entries for a specific location
     *
     * @param int $iStateUid
     * @param int $iDistrictUid
     * @param int $iCityUid
     * @param boolean $bCount
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function findByLocation($iStateUid = 0, $iDistrictUid = 0, $iCityUid = 0, $bCount = true) {
		$query 	= $this->createQuery();

		$aWhere	= array();

		if($iStateUid > 0)
			$aWhere[]	= $query->equals('relation_state', (int)$iStateUid);

		if($iDistrictUid > 0)
			$aWhere[]	= $query->equals('relation_district', (int)$iDistrictUid);
		
		if($iCityUid > 0)
			$aWhere[]	= $query->equals('relation_city', (int)$iCityUid);

		$query->matching(
			$query->logicalAnd($aWhere)
		);

		if($bCount)
			return $query->count();

    	return $query->execute();
	}

    /**
     * Get entries ordered by views and a limit of 10
     *
     * @param string $sOrderBy
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function getStats($sOrderBy) {
		$query 	= $this->createQuery();

		$aOrder = array();
		$aOrder[$sOrderBy] = \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING;
		
		$query->setOrderings($aOrder);
		$query->setLimit(10);

		return $query->execute();
	}
}
