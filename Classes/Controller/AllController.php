<?php
namespace mhdev\MhDirectory\Controller;

class AllController 
	extends ActionController {

	public function indexAction() {
		$aResults	= $this->entryRepository->findAll();

		if($this->settings['googlemaps'] == 1)
			$this->response->addAdditionalHeaderData('<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>');

		$this->view->assign('result', $aResults);
	}
}