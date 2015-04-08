<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district',
        'label' => 'import_status',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => TRUE,
        'sortby' => 'sorting',
        'versioningWS' => 2,
        'versioning_followPages' => TRUE,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('mh_directory') . 'Resources/Public/Icons/tx_mhdirectory_domain_model_backend.gif',
        'searchFields' => 'import_status'
    ),
    'interface' => array(
        'showRecordFieldList' => 'relations_federal, relations_administrative, relations_cities, relation_entries, import_status, finished',
    ),
    'columns' => array(
        'finished'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.hidden',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
        ),   
        'relations_federal'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.relations_federal',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),    
        'relations_administrative'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.relations_administrative',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),    
        'relations_cities'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.relations_cities',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),    
        'relations_entries'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.relations_entries',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),
        'import_status'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_backend.import_status',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required'
            ),
        ), 

    ),
'types' => array(
    '1' => array('showitem' => 'finished, relations_federal, relations_administrative, relations_cities, relation_entries'),
),
'palettes' => array(
    '1' => array('showitem' => ''),
),
);