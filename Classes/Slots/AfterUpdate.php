<?php
namespace mhdev\MhDirectory\Slots;

class AfterUpdate {
    public function update(\TYPO3\CMS\Extbase\DomainObject\DomainObjectInterface $object) {
    	echo 'hello';
    }
}