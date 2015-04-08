<?php

class Tx_MhDirectory_ViewHelpers_OpeningViewHelper 
	extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	*	@param string $value
	*	@param boolean $opencheck
	*	@param array $settings
	*	@return string formatted string 
	*/
	public function render($value, $opencheck, $settings) {
		$aTranslations = array(
			'mo' => 'Mon', 'di' => 'Tue', 'mi' => 'Wed', 'do' => 'Thu', 'fr' => 'Fri', 'sa' => 'Sat', 'so' => 'Sun'
		);
		$aByBreak = explode("\n", $value);
		
		if($opencheck == 1) {
			$timestamp = time();
			$status = 'closed';
			$sToday = (new DateTime())->setTimestamp($timestamp);

			$aOpening = array(
				'Mon' => array(),
				'Tue' => array(),
				'Wed' => array(),
				'Thu' => array(),
				'Fri' => array(),
				'Sat' => array(),
				'Sun' => array(),
			);

			foreach($aByBreak AS $sVal) {
				$aValues = explode(' ', $sVal);
				if(count($aValues) > 1) {
					$sDay 	= trim($aValues[0]);
					$sTime1 = isset($aValues[1]) ? trim($aValues[1]) : false;
					$sTime2 = isset($aValues[2]) ? trim($aValues[2]) : false;

					if(!isset($aOpening[$sDay])) {
						if(!isset($aTranslations[strtolower($sDay)]))
							continue;

						$sDay = $aTranslations[strtolower($sDay)];
					}

					if(isset($aOpening[$sDay])) {
						if($sTime1 && $sTime1 != '-') {
							$aTime1 = explode('-', $sTime1);
							$aOpening[$sDay][$aTime1[0]] = $aTime1[1]; 
						}

						if($sTime2 && $sTime2 != '-') {
							$aTime2 = explode('-', $sTime2);
							$aOpening[$sDay][$aTime2[0]] = $aTime2[1]; 
						}
					}
				}
			}

			foreach($aOpening[date('D', $timestamp)] AS $sStartTime => $sEndTime) {
				$startTime = DateTime::createFromFormat('H:i', $sStartTime);
				$endTime   = DateTime::createFromFormat('H:i', $sEndTime);
				if (($startTime < $sToday) && ($sToday < $endTime)) {
			        $status = 'open';
			        break;
			    }
			}

			return '<span class="badge opening_hours_status ' . $status . '">' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('opening_hours_status_' . $status, 'mh_directory') . '</span>';
		} else {
			$sOutput 	= '<dl class="opening_hours">';
			if(count($aByBreak) > 0) {
				foreach($aByBreak AS $sVal) {
					$aValues = explode(' ', $sVal);
					if(count($aValues) > 0) {
						$sDay 	= isset($aValues[0]) ? trim($aValues[0]) : false;
						$sTime1 = isset($aValues[1]) ? trim($aValues[1]) : false;
						$sTime2 = isset($aValues[2]) ? trim($aValues[2]) : false;

						if(!$sDay) continue;

						$sDay = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('opening_hours_day_' . strtolower($sDay), 'mh_directory');

						if($sTime1 && $sTime1 != '-') {
							$sTime1 .= ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('opening_hours_clock_suffix_am', 'mh_directory');
						} else {
							$sTime1 = '';
						}

						if($sTime2 && $sTime2 != '-') {
							$sTime2 .= ' ' . \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('opening_hours_clock_suffix_pm', 'mh_directory');
						} else {
							$sTime2 = '';

							if($sTime1 != '')
								$sTime2 .= '';
						}

						if($sTime1 == '' && $sTime2 == '') {
							if((int)$settings['entry_opening_hide_closed'] == 1) continue;
							$sTime1 = \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('opening_hours_closed', 'mh_directory');
						}

						$sOutput .= '<dt>' . $sDay . '</dt>';
						$sOutput .= '<dd>';

						if($sTime1 != '')
							$sOutput .= '<span class="opening_am">' . $sTime1 . '</span>';

						if($sTime2 != '')
							$sOutput .= '<span class="opening_pm">' . $sTime2 . '</span></dd>';
					}
				}
			}
			$sOutput .= '</dl>';
		}

		return $sOutput;
	}
}