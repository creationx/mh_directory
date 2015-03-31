<?php
namespace mhdev\MhDirectory\Domain\Repository;

class TypeRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

}
