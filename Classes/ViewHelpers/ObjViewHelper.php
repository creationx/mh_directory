<?php

class Tx_MhDirectory_ViewHelpers_ObjViewHelper 
	extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	*	@param object $obj
	*	@param string $prob
	*	@return mixed
	*/
	public function render($obj,$prob) {
		if(is_object($obj))
			return $obj->$prop;

		if(is_array($obj))
			if(array_key_exists($prob, $obj))
				return $obj[$prob];
	}
}

?>