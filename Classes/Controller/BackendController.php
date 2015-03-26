<?php
namespace mhdev\MhDirectory\Controller;

class BackendController 
	extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	public $contentObj;

	public function initializeAction() {
		$this->contentObj = $this->configurationManager->getContentObject();
	}

	public function indexAction() {
		$configurationManager = t3lib_div::makeInstance('Tx_Extbase_Configuration_BackendConfigurationManager');
		$this->settings = $configurationManager->getConfiguration(
			$this->request->getControllerExtensionName(),
			$this->request->getPluginName()
		);		
	}

}



?>