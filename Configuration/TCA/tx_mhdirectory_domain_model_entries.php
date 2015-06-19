<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries',
        'label' => 'name_intern',
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
        'requestUpdate' => 'relation_state,relation_district',
        'enablecolumns' => array(
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ),
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('mh_directory') . 'Resources/Public/Icons/tx_mhdirectory_domain_model_entries.gif',
        'searchFields' => 'name_intern, company, lastname'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name_intern, company, forename, middlename, lastname, address, zip, city, phone, mobile, fax, link, mail, twitter, facebook, xing, linkedin, custom1, custom2, custom3, map_lng, map_lat, opening, image, description, count_clicks, count_views',
    ),
    'columns' => array(
        'hidden'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.hidden',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
        ),   

        'relation_state'   => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_state',
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
            ),
        ),
        
        'relation_district'   => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_district',
            'displayCond' => 'FIELD:relation_state:>:0',
            'config' => array(
                'type' => 'select',
                'items' => array(
                        array('', 0)
                ),
                'foreign_table' => 'tx_mhdirectory_domain_model_district',
                'foreign_table_where' => 'AND tx_mhdirectory_domain_model_district.relation_state=###REC_FIELD_relation_state### ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems'  => 1,
            ),
        ),

        'relation_city'   => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_city',
            'displayCond' => 'FIELD:relation_district:>:0',
            'config' => array(
                'type' => 'select',
                'items' => array(
                        array('', 0)
                ),
                'foreign_table' => 'tx_mhdirectory_domain_model_city',
                'foreign_table_where' => 'AND tx_mhdirectory_domain_model_city.relation_district=###REC_FIELD_relation_district###  ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems'  => 1,
            ),
        ),

        'relation_type'   => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_type',
            'config' => array(
                'type' => 'select',
                'items' => array(),
                'foreign_table' => 'tx_mhdirectory_domain_model_type',
                'foreign_table_where' => 'ORDER BY name ASC',
                'size' => 1,
                'minitems' => 1,
                'maxitems'  => 1,
            ),
        ),

        'name_intern'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.name_intern',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required'
            ),
        ),        
        'company'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.company',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'forename'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.forename',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'middlename'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.middlename',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'lastname'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.lastname',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'address'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.address',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'zip'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.zip',
            'config' => array(
                'type' => 'input',
                'size' => 5,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'city'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.city',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'phone'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.phone',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),            
        'mobile'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.mobile',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'fax'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.fax',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'link'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.link',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
                'wizards' => array(
                    '_PADDING' =>  2,
                    'link' => array(
                        'type' => 'popup',
                        'title' => 'Link',
                        'icon' => 'link_popup.gif',
                        'script' => 'browse_links.php?mode=wizard',
                        'JSopenParams' => 'height=350,width=550,status=0,menubar=0,scrollbars=1',
                    ),
                ),
                'softref' => 'typolink',
            ),
        ),        
        'mail'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.mail',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'twitter'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.twitter',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'facebook'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.facebook',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),         
        'xing'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.xing',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),         
        'linkedin'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.linkedin',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'custom1'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom1',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'custom2'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom2',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'custom3'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom3',
            'config' => array(
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),
        'map_lng'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.map_lng',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'map_lat'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.map_lat',
            'config' => array(
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ),
        ),        
        'image'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.image',
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
        'last_calls'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.last_calls',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),  
        'description'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),   
        'opening'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.opening',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ), 
        'count_clicks'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_clicks',
            'config' => array(
                'type' => 'none',
            ),
        ),  
        'count_views'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_views',
            'config' => array(
                'type' => 'none',
            ),
        ),    
        'count_link'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_link',
            'config' => array(
                'type' => 'none',
            ),
        ),    
        'count_twitter'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_twitter',
            'config' => array(
                'type' => 'none',
            ),
        ),    
        'count_facebook'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_facebook',
            'config' => array(
                'type' => 'none',
            ),
        ),      
        'count_xing'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_xing',
            'config' => array(
                'type' => 'none',
            ),
        ),      
        'count_linkedin'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_linkedin',
            'config' => array(
                'type' => 'none',
            ),
        ),  
        'categories'    => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.categories',
            'config' => array(
                'type' => 'select',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.sorting ASC',
                'MM' => 'tx_mhdirectory_entries__mm',
                'size' => 10,
                'autoSizeMax' => 50,
                'maxitems' => 9999,
                'renderMode' => 'tree',
                'treeConfig' => array(
                    'parentField' => 'parent',
                    'appearance' => array(
                        'expandAll' => TRUE,
                        'showHeader' => TRUE,
                    ),
                ),
            ),
        ),
    ),
'types' => array(
    '1' => array(
        'showitem' => '--div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_general,
                        hidden, relation_type,--palette--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.palette_relations;3,name_intern, company, --palette--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.palette_name;1, image, description,
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_address,
                        address, --palette--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.palette_city;2, --palette--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.palette_phone;4, opening, link, mail, 
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_social,
                        twitter, facebook, xing, linkedin, --palette--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.palette_geo;5, 
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_categories,
                        categories,
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_custom,
                        custom1, custom2, custom3,
                        --div--;LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.tab_stats,
                        count_clicks, count_views, count_link, count_twitter, count_facebook, count_xing, count_linkedin
                        '),
),
'palettes' => array(
    '1' => array('showitem' => 'forename, middlename, lastname', 'canNotCollapse' => 1),
    '2' => array('showitem' => 'zip, city', 'canNotCollapse' => 1),
    '3' => array('showitem' => 'relation_state, relation_district, relation_city', 'canNotCollapse' => 1),
    '4' => array('showitem' => 'phone, mobile, fax', 'canNotCollapse' => 1),
    '5' => array('showitem' => 'map_lat, map_lng', 'canNotCollapse' => 1),
),
);