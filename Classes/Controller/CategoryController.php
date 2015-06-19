<?php
namespace mhdev\MhDirectory\Controller;

class CategoryController 
	extends ActionController {

	public function indexAction() {
		$aRequest		= $this->request->getArguments();
		$aCategories 	= array();
		$aResults		= array();

		if($this->settings['categories'] != '') {
			$aCategories = $this->categoriesRepository->findSubAsRecursiveTreeArray($this->settings['categories']);
		} else {
			$aCategories = $this->categoriesRepository->findAllAsRecursiveTreeArray();
		}


		if(isset($aRequest['category']) && (int)$aRequest['category'] > 0) {
			$aFilter 	= $this->getFilter(array('categories' => $aRequest['category']));

			if(count($aFilter['categories']) > 0) 
				$aResults 	= $this->entryRepository->getFiltered($aFilter);
			
			$aBreadcrumb = $this->getBreadcrumb($aRequest);
			
			$this->view->assign('breadcrumb', $aBreadcrumb);
			$this->view->assign('getEntries', true);
		}
		

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		$this->view->assign('result', $aResults);
		$this->view->assign('categories', $aCategories);
		$this->view->assign('request', $aRequest);
	}

	public function getBreadcrumb($aRequest = array()) {
		$aBreadcrumb 	= $this->categoriesRepository->getBreadcrumb($aRequest['category']);
		sort($aBreadcrumb);
		return $aBreadcrumb;
	}
}