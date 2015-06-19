<?php
namespace mhdev\MhDirectory\Domain\Repository;

class CategoriesRepository 
	extends \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository {

    protected $defaultOrderings = array(
        'title' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    /**
     * Finds categories based on a selection (CSV list)
     *
     * @param string $selectedCategories
     *
     * @return object
     */
    public function findSelectedCategories($selectedCategories) {
        $query = $this->createQuery();
        $constraints = array();
        $selectedCategories = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $selectedCategories);
        foreach($selectedCategories as $selectedCategory) {
            $constraints[] = $query->like('uid', $selectedCategory);
        }
        $query->matching(
            $query->logicalOr($constraints)
        );
        $result = $query->execute();
        return $result;
    }

    /**
     * Finds categories based on their parents, possibly taking categories2skip into account
     *
     * @param integer $parent
     * @param array $categories2skip
     *
     * @return object
     */
    public function findByParent($parent, $categories2skip = array()) {
        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->equals('parent', $parent);
        if (count($categories2skip) > 0) {
            $constraints[] = $query->logicalNot($query->in('uid', $categories2skip));
        }
        $query->matching(
            $query->logicalAnd($constraints)
        );
        $result = $query->execute();
        return $result;
    }



    /**
     * findAllAsRecursiveTreeArray
     *
     * @param \mhdev\MhDirectory\Domain\Model\Categories $selectedCategory
     * @return array $categories
     */
    public function findAllAsRecursiveTreeArray($selectedCategory = NULL) {
        $categoriesArray = $this->findAllAsArray($selectedCategory);
        $categoriesTree = $this->buildSubcategories($categoriesArray, NULL);
        return $categoriesTree;
    }

    /**
     * findSubAsRecursiveTreeArray
     *
     * @param string $selectedCategories
     * @return array $categories
     */
    public function findSubAsRecursiveTreeArray($selectedCategories) {
        $selectedCategories = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $selectedCategories);
        $categoriesArray    = array();

        foreach($selectedCategories AS $iCat) {
            $oTmp               = $this->findByUid((int)$iCat);
            $newCategory = array(
                'uid' => $oTmp->getUid(),
                'title' => $oTmp->getTitle(),
                'parent' => ($oTmp->getParent()?$oTmp->getParent()->getUid():NULL),
                'subcategories' => $this->getSubCategories($oTmp->getUid()),
                'isSelected' => ($selectedCategory == $oTmp ? true : false)
            );
            $categoriesArray[] = $newCategory;
            
        }
        
        return $categoriesArray;
    }

    public function getSubCategories($iParentId) {
        $categoriesArray = array();
        $aResults = $this->findByParent($iParentId);
        if($aResults) {
            foreach($aResults AS $oTmp) {
                $newCategory = array(
                    'uid' => $oTmp->getUid(),
                    'title' => $oTmp->getTitle(),
                    'parent' => ($oTmp->getParent()?$oTmp->getParent()->getUid():NULL),
                    'subcategories' => $this->getSubCategories($oTmp->getUid()),
                    'isSelected' => ($selectedCategory == $oTmp ? true : false)
                );
                $categoriesArray[] = $newCategory;
            }
        }

        return $categoriesArray;
    }

    public function getBreadcrumb($iCategory, $iLevel = 0) {
        $aResult    = array();
        $oTmp       = $this->findByUid((int)$iCategory);
        if($oTmp) {
            $aResult[$iLevel] = array(
                'uid'   => $oTmp->getUid(),
                'title' => $oTmp->getTitle()
            );
       
            if($oParent = $oTmp->getParent())
                $aResult = array_merge($aResult, $this->getBreadcrumb($oParent->getUid(), ($iLevel+1)));
        }

        return $aResult;
    }

    /**
     * findAllAsArray
     *
     * @param \mhdev\MhDirectory\Domain\Model\Categories $selectedCategory
     * @return array $categories
     */
    public function findAllAsArray($selectedCategory = NULL){
        $localCategories = $this->findAll();
        $categories = array();
        // Transform categories to array
        foreach($localCategories as $localCategory){
            $newCategory = array(
                'uid' => $localCategory->getUid(),
                'title' => $localCategory->getTitle(),
                'parent' => ($localCategory->getParent()?$localCategory->getParent()->getUid():NULL),
                'subcategories' => null,
                'isSelected' => ($selectedCategory == $localCategory ? true : false)
            );
            $categories[] = $newCategory;
        }
        return $categories;
    }

    /**
     * findSubcategoriesRecursiveAsArray
     *
     * @param \mhdev\MhDirectory\Domain\Model\Categories $parentCategory
     * @return array $categories
     */
    public function findSubcategoriesRecursiveAsArray($parentCategory){
        $categories = array();
        $localCategories = $this->findAllAsArray();
        foreach($localCategories as $category) {
            if(($parentCategory && $category['uid'] == $parentCategory->getUid()) || !$parentCategory) {
                $this->getSubcategoriesIds($localCategories, $category, $categories);
            }
        }
        return $categories;
    }


    /**
     * getSubcategoriesIds
     *
     * @param array $categoriesArray
     * @param array $parentCategory
     * @param array $subcategoriesArray
     * @return void
     */
    private function getSubcategoriesIds($categoriesArray,$parentCategory, 
    &$subcategoriesArray){
        $subcategoriesArray[] = $parentCategory['uid'];
        foreach($categoriesArray as $category){
            if($category['parent'] == $parentCategory['uid']){
                $this->getSubcategoriesIds($categoriesArray, $category, $subcategoriesArray);
            }
        }
    }


    /**
     * buildSubcategories
     *
     * @param array $categoriesArray
     * @param array $parentCategory
     * @return array $categories
     */
    private function buildSubcategories($categoriesArray,$parentCategory){
        $categories = NULL;
        foreach($categoriesArray as $category){
            if($category['parent'] == $parentCategory['uid']){
                $newCategory = $category;
                $newCategory['subcategories'] = $this->buildSubcategories($categoriesArray, $category);
                $categories[] = $newCategory;
            }
        }
        return $categories;
    }

}
