<?php
namespace mhdev\MhDirectory\Domain\Repository;

class BackendRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

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

	public function checkOldTables() {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$query->statement('SHOW tables like "tx_mhbranchenbuch_%"');

		return $query->execute();
	}


    /**
     * Get the count of entries in a table
     *
     * @param string $sTableName
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function getCountFromOldTable($sTableName) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$query->statement('SELECT COUNT(`uid`) AS `total` FROM `' . $sTableName . '` LIMIT 1');

		return $query->execute();
	}

    /**
     * Get all rows from a specific table
     *
     * @param string $sTableName
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function getRows($sTableName) {
		$query = $this->createQuery();
		$query->getQuerySettings()->setReturnRawQueryResult(TRUE);

		$query->statement('SELECT * FROM `' . $sTableName . '` ORDER BY `uid` DESC');

		return $query->execute();
	}

    /**
     * Get the last unfinished row
     *
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function getLastActive() {
		$query 	= $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(FALSE);
		$query->getQuerySettings()->setRespectSysLanguage(FALSE);

		$query->matching(
			$query->equals('finished', 0)
		);

		return $query->execute()->getFirst();
	}
}
