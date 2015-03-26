<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'mhdev.' . $_EXTKEY,
    'Pi1',
	array(
		'List' => 'index,detail,out,mail',
	),
	array(
		'List' => 'index,detail,out,mail',
	)
);
?>