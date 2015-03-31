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
	),
	array(
		'List' => 'index,detail,out,mail',
		'All' => 'index,detail',
	)
);

if (TYPO3_MODE === 'BE') {
	// $class = 'TYPO3\\CMS\\Extbase\\SignalSlot\\Dispatcher';
	// $dispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($class);
	// $dispatcher->connect(
	//     'TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Backend',
	//     'afterUpdateObject',
	//     'mhdev\\MhDirectory\\Slots\\AfterUpdate',
	//     'update'
	// );
}
?>