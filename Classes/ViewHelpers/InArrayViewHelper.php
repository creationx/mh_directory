<?php

class Tx_MhDirectory_ViewHelpers_InArrayViewHelper 
	extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	*	@param string $needle
	*	@param array $haystack
	*	@return boolean 
	*/
	public function render($needle, $haystack) {
		if(
			(
				is_array(($haystack)) && 
				strlen($needle) > 0
			) && in_array($needle, $haystack)) return true;
	}
}