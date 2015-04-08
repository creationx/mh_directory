<?php

class Tx_MhDirectory_ViewHelpers_TypeViewHelper 
	extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	*	@param object $entry
	*	@param string $key
	*	@return boolean 
	*/
	public function render($entry, $key) {
		$oType = $entry->getRelationType();

		// if the entry has no type assigned, then return false (what means, no permission)
		if(count($oType) == 0) return false;

		$aOptions = $this->getTypeOptions($oType->getOptions());

		if(in_array($key, $aOptions)) return true;
	}

	public function getTypeOptions($iValue) {
		$aOptions 	= array(
			0 => "detail", 
			1 => "image", 
			2 => "twitter", 
			3 => "facebook", 
			4 => "description", 
			5 => "map", 
			6 => "mail", 
			7 => "link",
			8 => "address",
			9 => "contact",
			10 => "custom1",
			11 => "custom2",
			12 => "custom3",
			13 => "opening"
		);

		$aOutput 	= array();
		for ($i=0; $i<(count($aOptions)); $i++) {
			if (($iValue >> $i) & 1) {
				$aOutput[] = $aOptions[$i];
			}
		}
		return $aOutput;
	}
}