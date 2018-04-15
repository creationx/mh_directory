<?php
namespace mhdev\MhDirectory\Controller;

class AlphabeticalController 
	extends ActionController {

	public function indexAction() {
		$aRequest	= $this->request->getArguments();
		$aOutput	= array();
		$aFilter	= $this->getFilter();
		$oEntries	= $this->entryRepository->getFiltered($aFilter);
		$aMenu 		= range('a', 'z');
		$aMenu[]	= '123';
		$aCount		= array();

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?&key='.$this->settings['googlemaps_apikey'].'&v=3.exp"></script>');

		$sKey 		= $this->settings['alphabetical_index'];
		$aValidKeys	= array('company', 'name_intern', 'city', 'custom1', 'custom2', 'custom3');
		if(!in_array($sKey, $aValidKeys)) $sKey = 'company';


		foreach($aMenu AS $sKey) $aOutput[strtolower($sKey)] = array();

		if($oEntries) {
			foreach($oEntries AS $oRow) {
				$sChar = '';
				switch ($sKey) {
					case 'company':
						$sChar = $oRow->getCompany()[0];
						break;
					case 'name_intern':
						$sChar = $oRow->getNameIntern()[0];
						break;
					case 'city': 
						$sChar = $oRow->getCity()[0];
						break;
					case 'custom1': 
						$sChar = $oRow->getCustom1()[0];
						break;
					case 'custom2': 
						$sChar = $oRow->getCustom2()[0];
						break;
					case 'custom3': 
						$sChar = $oRow->getCustom3()[0];
						break;
					default:
						$sChar = $oRow->getCompany()[0];
						break;
				}

				$sChar = strtolower($sChar);

				if(strlen($sChar) == 1) {
					if(is_numeric($sChar)) $sChar = '123';
					$aOutput[$sChar][] = $oRow;
					$aCount[$sChar] += 1;
				}
			}
		}

		if(isset($aRequest['ref']))
			$this->view->assign('ref', strtolower($aRequest['ref']));

		$this->view->assign('count', $aCount);
		$this->view->assign('menu', $aMenu);
		$this->view->assign('result', $aOutput);
		$this->view->assign('request', $aRequest);
	}
}