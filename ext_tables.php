<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}

$extensionName = strtolower(\TYPO3\CMS\Core\Utility\GeneralUtility::underscoredToUpperCamelCase($_EXTKEY));
$pluginName = strtolower('Pi1');
$pluginSignature = $extensionName.'_'.$pluginName; 

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    $_EXTKEY,
    'Pi1',
    'MH-Directory (List)'
);


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
    'mhdev.' . $_EXTKEY,
    'user',
    'management',
    '',
    array(
        'Backend' => 'index',
    ),
    array(
        'access' => 'user,group',
        'icon' => 'EXT:mh_directory/ext_icon.gif',
        'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
    )
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'mh_directory');


$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

?>