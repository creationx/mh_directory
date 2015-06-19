<?php
namespace mhdev\MhDirectory\Controller;

class ListController 
	extends ActionController {

	public function indexAction() {
		$aRequest		= $this->request->getArguments();
		$iStateUid 		= (int)$aRequest['state'];
		$iDistrictUid 	= (int)$aRequest['district'];
		$iCityUid 		= (int)$aRequest['city'];
		$iStatus 		= 0;
		$iMap 			= 0;
		$oEntries 		= false;
		$aBroadcrumb	= array();
		$aOutput		= array();

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		if($iCityUid > 0) {
			$iStatus			= 3;
			$oResStates 		= $this->entryRepository->findByRelationCity($iCityUid);
			$aBroadcrumb		= $this->getBreadcrumb($iStatus, $iCityUid);
		} else if($iDistrictUid > 0) {
			$iStatus 			= 2;
			$aBroadcrumb		= $this->getBreadcrumb($iStatus, $iDistrictUid);
			$oResStates 		= $this->cityRepository->findByDistrict($iDistrictUid);
			$oEntries 			= $this->entryRepository->findByRelationDistrict($iDistrictUid);
			$aGMapPois			= $this->generateGMapPois($oEntries);
		} else if($iStateUid > 0) {
			$iStatus 			= 1;
			$aBroadcrumb		= $this->getBreadcrumb($iStatus, $iStateUid);
			$oEntries 			= $this->entryRepository->findByRelationState($iStateUid);
			$aGMapPois			= $this->generateGMapPois($oEntries);
			$oResStates 		= $this->districtRepository->findByState($iStateUid);
		} else {
			$oEntries 			= $this->entryRepository->findAll();
			$aGMapPois			= $this->generateGMapPois($oEntries);
			$oResStates 		= $this->stateRepository->findAll();
		}

		if($iCityUid == 0) {
			if(count($oResStates) > 0) {
				foreach($oResStates AS $oState) {
					$iNumberOfEntries = 0;
					if($this->settings['list_show_number_of_entries'] == 1) {
						if($iStatus == 0) {
							$iNumberOfEntries 	= (int)$this->entryRepository->findByLocation((int)$oState->getUid());
						} else if($iStatus == 1) {
							$iNumberOfEntries 	= (int)$this->entryRepository->findByLocation(0, (int)$oState->getUid());
						} else if($iStatus == 2) {
							$iNumberOfEntries 	= (int)$this->entryRepository->findByLocation(0, 0, (int)$oState->getUid());
						}
					}

					// update views
					switch($iStatus) {
						case 0:
							$oState->setCountViews(($oState->getCountViews() + 1));
							$this->stateRepository->update($oState);
							break;
						case 1:
							$oState->setCountViews(($oState->getCountViews() + 1));
							$this->districtRepository->update($oState);
							break;
						case 2:
							$oState->setCountViews(($oState->getCountViews() + 1));
							$this->cityRepository->update($oState);
							break;
					}

					if($this->settings['list_hide_empty'] == 1 && $iNumberOfEntries == 0)
						continue; 

					$aTmp	= array(
						'uid'	=> $oState->getUid(),
						'name'	=> $oState->getName(),
						'description' => $oState->getDescription(),
						'number_of_entries'	=> $iNumberOfEntries,
						'mapLat' => $oState->getMapLat(),
						'mapLng' => $oState->getMapLng()
					);

					if(is_file(PATH_site . '/uploads/tx_mhdirectory/' . $oState->getImage()))
						$aTmp['image'] = $oState->getImage();

					$aOutput[] = $aTmp;
				}
			}
		} else {
			if(count($oResStates) > 0) {
				$aOutput 	= $oResStates;
			}
		}

		$this->view->assign('breadcrumb', $aBroadcrumb);
		$this->view->assign('status', $iStatus);
		$this->view->assign('state', $iStateUid);
		$this->view->assign('district', $iDistrictUid);
		$this->view->assign('city', $iCityUid);
		$this->view->assign('result', $aOutput);
		$this->view->assign('gmap_pois', $aGMapPois);
	}

	// public function detailAction() {
	// 	$aRequest		= $this->request->getArguments();
	// 	$iUid 			= (int)$aRequest['uid'];
	// 	$aOutput 		= array();

	// 	$oEntry			= $this->entryRepository->findByUid($iUid);

	// 	$sIpAdress	= $_SERVER['REMOTE_ADDR'];
	// 	$aLastCalls	= (array)unserialize($oEntry->getLastCalls());

	// 	if(!in_array($sIpAdress, $aLastCalls['main'])) {
	// 		$oEntry->setCountClicks(($oEntry->getCountClicks+1));
	// 		$aLastCalls['main'][]	= $_SERVER['REMOTE_ADDR'];
	// 		if(count($aLastCalls) > 30) unset($aLastCalls['main'][(count($aLastCalls)-1)]);
	// 		$oEntry->setLastCalls(serialize($aLastCalls));
	// 	}

	// 	$oEntry->setCountViews(($oEntry->getCountViews() + 1));

	// 	$this->entryRepository->update($oEntry);

	// 	if($oEntry) {
	// 		$aBreadcrumb		= $this->getBreadcrumb(4, $iUid);
	// 		$this->view->assign('breadcrumb', $aBreadcrumb);
	// 		$this->view->assign('result', $oEntry);
	// 	}

	// 	if($this->settings['googlemaps'] == 1)
	// 		$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');
	// }

	public function outAction() {
		$aRequest		= $this->request->getArguments();
		$iUid 			= (int)$aRequest['uid'];
		$sKey 			= $aRequest['key'];
		$aOutput 		= array();
		
		$oEntry			= $this->entryRepository->findByUid($iUid);

		$bStats			= false;
		$sIpAdress		= $_SERVER['REMOTE_ADDR'];
		$aLastCalls		= (array)unserialize($oEntry->getLastCalls());

		if(isset($aLastCalls['out'][$sKey])){
			if(!in_array($sIpAdress, $aLastCalls['out'][$sKey])) {
				$aLastCalls['out'][$sKey][]	= $_SERVER['REMOTE_ADDR'];
				if(count($aLastCalls) > 30) unset($aLastCalls['out'][$sKey][(count($aLastCalls)-1)]);
				$bStats = true;
				$oEntry->setLastCalls(serialize($aLastCalls));
			}
		} else {
			$aLastCalls['out'][$sKey][]	= $_SERVER['REMOTE_ADDR'];
			$bStats = true;
			$oEntry->setLastCalls(serialize($aLastCalls));
		}
 
		if($oEntry) {
			switch ($sKey) {
				case 'link':
					$aOutput['link']	= $oEntry->getLink();
					if($bStats) $oEntry->setCountLink(($oEntry->getCountLink+1));
					break;
				case 'twitter':
					$aOutput['link']	= 'http://twitter.com/' . $oEntry->getTwitter();
					if($bStats) $oEntry->setCountTwitter(($oEntry->getCountTwitter+1));
					break;
				case 'facebook':
					$aOutput['link']	= 'http://facebook.com/' . $oEntry->getFacebook();
					if($bStats) $oEntry->setCountFacebook(($oEntry->getCountFacebook+1));
					break;
				case 'xing':
					$aOutput['link']	= $oEntry->getXing();
					if($bStats) $oEntry->setCountXing(($oEntry->getCountXing+1));
					break;
				case 'linkedin':
					$aOutput['link']	= $oEntry->getLinkedin();
					if($bStats) $oEntry->setCountLinkedin(($oEntry->getCountLinkedin+1));
					break;
			}
		}

		if($bStats)
			$this->entryRepository->update($oEntry);

		$this->view->assign('key', $sKey);
		$this->view->assign('resultObject', $oEntry);
		$this->view->assign('result', $aOutput);
	}

	public function getBreadcrumb($iStatus, $iUniqueKey) {
		$aOutput = array();
		if((int)$iUniqueKey == 0) return $aOutput;

		switch ($iStatus) {
			case 1:
				$oState = $this->stateRepository->findByUid($iUniqueKey);
				$aOutput[] = array(
					'name' 	=> $oState->getName(),
					'uid'	=> $oState->getUid()
				);
				break;
			case 2:
				$oDistrict 	= $this->districtRepository->findByUid($iUniqueKey);
				$oState 	= $oDistrict->getRelationState();

				if($oState)
					$aOutput[] = array(
						'name' 	=> $oState->getName(),
						'uid'	=> $oState->getUid()
					);

				$aOutput[] = array(
					'name' 	=> $oDistrict->getName(),
					'uid'	=> $oDistrict->getUid(),
					'state' => $oDistrict->getRelationState()
				);
				break;

			case 3: 
				$oCity		= $this->cityRepository->findByUid($iUniqueKey);
				$oDistrict 	= $oCity->getRelationDistrict();
				$oState 	= $oDistrict->getRelationState();

				if($oState)
					$aOutput[] = array(
						'name' 	=> $oState->getName(),
						'uid'	=> $oState->getUid()
					);

				if($oDistrict)
					$aOutput[] = array(
						'name' 	=> $oDistrict->getName(),
						'uid'	=> $oDistrict->getUid(),
						'state' => $oDistrict->getRelationState()
					);

				$aOutput[] = array(
					'name' 	=> $oCity->getName(),
					'uid'	=> $oCity->getUid(),
					'state' => $oState->getUid(),
					'district' => $oDistrict->getUid()
				);

				break;
			
			case 4:
				$oEntry 	= $this->entryRepository->findByUid($iUniqueKey);
				$oCity		= $oEntry->getRelationCity();
				$oDistrict 	= $oEntry->getRelationDistrict();
				$oState 	= $oEntry->getRelationState();

				if($oState)
					$aOutput[] = array(
						'name' 	=> $oState->getName(),
						'uid'	=> $oState->getUid()
					);

				if($oDistrict)
					$aOutput[] = array(
						'name' 	=> $oDistrict->getName(),
						'uid'	=> $oDistrict->getUid(),
						'state' => $oDistrict->getRelationState()
					);

				if($oCity)
					$aOutput[] = array(
						'name' 	=> $oCity->getName(),
						'uid'	=> $oCity->getUid(),
						'state' => $oState->getUid(),
						'district' => $oDistrict->getUid()
					);

				$aOutput[] = array(
					'name' => $oEntry->getCompany()
				);
				break;
		}

		return $aOutput;
	}
}
?>