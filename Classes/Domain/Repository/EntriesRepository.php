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

	/**
	*	Creates a query with defined filter
	*
	*	@param array $aFilter
	*
	*	@return mhdev\MhDirectory\Domain\Repository $query
	*/
	public function getFiltered($aFilter) {
		$query 	= $this->createQuery();
		$aWhere	= array();

		/* Only show entries in this category */
		if(isset($aFilter['categories']) && count($aFilter['categories']) > 0) {
			$aTmpWhere = array();
			foreach($aFilter['categories'] AS $aRow) {
				$aTmpWhere[] = $query->equals('uid', (int)$aRow['uid_local']);
			}
			$aWhere[] = $query->logicalOr($aTmpWhere);
		}

		/* Only display this type of entries ... */
		if(isset($aFilter['typesToDisplay']) && strlen($aFilter['typesToDisplay']) > 0) {
			$aWhere[] = $query->in('relationType', explode(',', $aFilter['typesToDisplay']));
		}

		/* Search-Term */
		$aWhereSearch	= array();
		if(isset($aFilter['searchTerm']) && strlen($aFilter['searchTerm']) > 0) {
			$aSearchTerms	= explode(' ', $aFilter['searchTerm']);
			$aTmpWhere 		= array();
			if(count($aSearchTerms) > 0) {
				foreach($aSearchTerms AS $sVal) {
					$aWhereSearch[] = $query->like('company', '%' . $sVal . '%');
					$aWhereSearch[] = $query->like('description', '%' . $sVal . '%');
					$aWhereSearch[] = $query->like('city', '%' . $sVal . '%');
					$aWhereSearch[] = $query->like('lastname', '%' . $sVal . '%');
					$aWhereSearch[] = $query->like('forename', '%' . $sVal . '%');
					$aWhereSearch[] = $query->like('middlename', '%' . $sVal . '%');
				}
			}
		}

		/* Search-Zip */
		if(isset($aFilter['searchZip']) && strlen($aFilter['searchZip']) > 0) {
			$aWhereSearch[] = $query->like('zip', '%' . $aFilter['searchZip'] . '%');
		}

		if(count($aWhereSearch) > 0)
			$aWhere[] = $query->logicalOr($aWhereSearch);

		/* Collect all where conditions */
		if(count($aWhere) > 0) {
			$query->matching(
				$query->logicalAnd($aWhere)
			);
		}

		// \TYPO3\CMS\Extbase\Utility\DebuggerUtility::var_dump($aWhere);

		/* Order By ... */
		if(isset($aFilter['orderby']) && strlen($aFilter['orderby']) > 0) {
			switch ($aFilter['orderby']) {
				case 'relation_type1':
				default:
					$query->setOrderings(
						array(
							'relationType.sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
							'company' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
						)
					);
					break;

				case 'relation_type2':
					$query->setOrderings(
						array(
							'relationType.sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
							'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
						)
					);
					break;

				case 'relation_type3':
					$query->setOrderings(
						array(
							'relationType.sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
							'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
						)
					);
					break;

				case 'company':
					$query->setOrderings(
						array(
							'company' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
						)
					);
					break;

				case 'crdate':
					$query->setOrderings(
						array(
							'crdate' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING
						)
					);
					break;

				case 'sorting':
					$query->setOrderings(
						array(
							'sorting' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
						)
					);
					break;
			}
		}

		return $query->execute();
	}


    /**
     * Get entries by categories
     *
     * @param array $categories
     *
     * @return mhdev\MhDirectory\Domain\Repository $query
     */
	public function findByCategories(array $categories) {
		$query 	= $this->createQuery();
		$query->statement('SELECT `uid_local` FROM `tx_mhdirectory_entries__mm` WHERE FIND_IN_SET(uid_foreign, "' . implode(',', $categories) . '")');
		return $query->execute(true);
	}
}
