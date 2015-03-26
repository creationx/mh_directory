<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district',
        'label' => 'name',
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
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('mh_directory') . 'Resources/Public/Icons/tx_mhdirectory_domain_model_district.gif',
        'searchFields' => 'name'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, relation_state, name, map_lng, map_lat, image, description, count_clicks, count_views',
    ),
    'columns' => array(
        'hidden'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.hidden',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
        ),   
        'relation_state'   => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.relation_state',
            'config' => array(
                'type' => 'select',
                'items' => array(
                        array('', 0)
                ),
                'foreign_table' => 'tx_mhdirectory_domain_model_state',
                'foreign_table_where' => 'ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems'  => 1,
                'wizards' => array(
                    'suggest' => array(    
                        'type' => 'suggest',
                    ),
                ),
            ),
        ),
        'name'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required'
            ),
        ),        
        'map_lng'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.map_lng',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'map_lat'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.map_lat',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'image'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.image',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder'  => 'uploads/tx_mhdirectory',
                'show_thumbs' => 1,
                'size' => 5,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
                'minitems' => 0,
                'maxitems' => 5
            ),
        ),
        'description'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ), 
        'count_clicks'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.count_clicks',
            'config' => array(
                'type' => 'none',
            ),
        ),  
        'count_views'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.count_views',
            'config' => array(
                'type' => 'none',
            ),
        ),  
    ),
'types' => array(
    '1' => array(
        'showitem' => '--div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.tab_general,
                        hidden, relation_state, name, image, description,
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.tab_geo,
                        map_lng, map_lat,
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_district.tab_stats,
                        count_clicks, count_views; 
                        '),
),
'palettes' => array(
    '1' => array('showitem' => ''),
),
);