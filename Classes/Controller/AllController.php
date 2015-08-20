<?php
namespace mhdev\MhDirectory\Controller;

class AllController 
	extends ActionController {

	public function indexAction() {
		$aRequest	= $this->request->getArguments();
		$aFilter	= $this->getFilter();
		$aResults	= $this->entryRepository->getFiltered($aFilter);

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		$aGmapPois = $this->generateGMapPois($aResults);

		$this->view->assign('result', $aResults);
		$this->view->assign('gmap_pois', $aGmapPois);
		$this->view->assign('request', $aRequest);
	}
}