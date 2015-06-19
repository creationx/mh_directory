<?php
namespace mhdev\MhDirectory\Slots;

class AfterUpdate {
    public function update(\TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object) {
    	mail('info@mh-dev.de', 'test', print_r($object));
		// \TYPO3\CMS\Core\Utility\DebugUtility::debug($object);
    }
}