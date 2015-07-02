<?php
namespace mhdev\MhDirectory\Hooks;
class AfterUpdateHook {
	/**
	*	Automaticly populate LAT & LNG for entries
	*
	**/
	function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, &$pObj) {

		$aValidTables = array(
			'tx_mhdirectory_domain_model_state',
			'tx_mhdirectory_domain_model_entries',
			'tx_mhdirectory_domain_model_district',
			'tx_mhdirectory_domain_model_city'
		);

		if(in_array($table, $aValidTables) && $status =='update') {
			$row = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord($table, $id);
			if($row) {

				if($table == 'tx_mhdirectory_domain_model_entries') {
					$sAddress 	= $row['zip'] . ' ' . $row['city'] . ' ' . $row['address'];
				} else {
					$sAddress	= $row['name'];
				}
				
				$sAddress 	= urlencode($sAddress);
				$sUrl 		= "https://maps.googleapis.com/maps/api/geocode/json?address=" .$sAddress;

				$aData = json_decode(@file_get_contents($sUrl));
				if(count($aData) > 0) {
					$aGeo = (array)$aData->results[0]->geometry->location;
					if(isset($aGeo)) {
						$aUpdateData = array();
						if($row['map_lng'] == '' && isset($aGeo['lng']))
							$aUpdateData['map_lng'] = $aGeo['lng'];

						if($row['map_lat'] == '' && isset($aGeo['lat']))
							$aUpdateData['map_lat'] = $aGeo['lat'];

						if(count($aUpdateData) > 0) 
							$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table, 'uid=' . (int)$id, $aUpdateData);
					}
				}			
			}
		}
	}
}