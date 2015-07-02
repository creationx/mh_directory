<?php

class Tx_MhDirectory_ViewHelpers_MapIconViewHelper 
	extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	*	@param object $entry
	*	@param string $key
	*	@return boolean 
	*/
	public function render($entry) {
		$sMapIcon 	= 'typo3conf/ext/mh_directory/Resources/Public/Icons/pin3.png';
		$oType 		= $entry->getRelationType();
		// if the entry has no type assigned, then return false (what means, no permission)
		if(count($oType) == 0) return $sMapIcon;

		if((int)$oType->getPoiSelect() > 0) {
			$sMapIcon = 'typo3conf/ext/mh_directory/Resources/Public/Icons/pin' . $oType->getPoiSelect() . '.png';
		}

		return $sMapIcon;
	}
}