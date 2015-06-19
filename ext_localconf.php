<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'mhdev.' . $_EXTKEY,
    'Pi1',
	array(
		'List' => 'index,detail,out,mail',
		'All' => 'index,detail',
		'Alphabetical' => 'index,detail',
		'Category' => 'index,detail',
	),
	array(
		'List' => 'index,detail,out,mail',
		'All' => 'index,detail',
		'Alphabetical' => 'index,detail',
		'Category' => 'index,detail',
	)
);

// Hook
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = '\\mhdev\\MhDirectory\\Hooks\AfterUpdateHook';

// RealUrl
// if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('realurl')) {
// 	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/realurl/class.tx_realurl_autoconfgen.php']['extensionConfiguration']['mhdirectory'] =
// 		'mhdev\\MhDirectory\\Hooks\\RealUrlAutoConfiguration->addConfig';
// }


/*
$signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
	'TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher'
);


$signalSlotDispatcher->connect(
    'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Backend',
    'afterUpdateObject',
    'mhdev\\MhDirectory\\Slots\\AfterUpdate',
    'update'
);
*/
?>