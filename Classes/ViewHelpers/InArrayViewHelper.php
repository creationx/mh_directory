<?php

class Tx_MhDirectory_ViewHelpers_InArrayViewHelper 
	extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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