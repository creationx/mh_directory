<?php
namespace mhdev\MhDirectory\Domain\Repository;

class StateRepository 
	extends \TYPO3\CMS\Extbase\Persistence\Repository {

    protected $defaultOrderings = array(
        'name' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

}
