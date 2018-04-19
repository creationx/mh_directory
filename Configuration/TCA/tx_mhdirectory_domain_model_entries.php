<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries',
        'label' => 'name_intern',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'sortby' => 'sorting',
        'versioningWS' => 2,
        'versioning_followPages' => true,
        'origUid' => 't3_origuid',
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'requestUpdate' => 'relation_state,relation_district',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('mh_directory') . 'Resources/Public/Icons/tx_mhdirectory_domain_model_entries.gif',
        'searchFields' => 'name_intern, company, lastname'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name_intern, company, forename, middlename, lastname, address, zip, city, phone, mobile, fax, link, mail, twitter, facebook, xing, linkedin, custom1, custom2, custom3, map_lng, map_lat, opening, image, description, count_clicks, count_views',
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.hidden',
            'config' => [
                'type' => 'check',
                'default' => 0
            ],
        ],

        'relation_state' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_state',
            'config' => [
                'type' => 'select',
                'items' => [
                        ['', 0]
                ],
                'foreign_table' => 'tx_mhdirectory_domain_model_state',
                'foreign_table_where' => 'ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'relation_district' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_district',
            'displayCond' => 'FIELD:relation_state:>:0',
            'config' => [
                'type' => 'select',
                'items' => [
                        ['', 0]
                ],
                'foreign_table' => 'tx_mhdirectory_domain_model_district',
                'foreign_table_where' => 'AND tx_mhdirectory_domain_model_district.relation_state=###REC_FIELD_relation_state### ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'relation_city' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_city',
            'displayCond' => 'FIELD:relation_district:>:0',
            'config' => [
                'type' => 'select',
                'items' => [
                        ['', 0]
                ],
                'foreign_table' => 'tx_mhdirectory_domain_model_city',
                'foreign_table_where' => 'AND tx_mhdirectory_domain_model_city.relation_district=###REC_FIELD_relation_district###  ORDER BY name ASC',
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
            ],
        ],

        'relation_type' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.relation_type',
            'config' => [
                'type' => 'select',
                'items' => [],
                'foreign_table' => 'tx_mhdirectory_domain_model_type',
                'foreign_table_where' => 'ORDER BY name ASC',
                'size' => 1,
                'minitems' => 1,
                'maxitems' => 1,
            ],
        ],

        'name_intern' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.name_intern',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required'
            ],
        ],
        'company' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.company',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'forename' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.forename',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'middlename' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.middlename',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'lastname' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.lastname',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'address' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.address',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'zip' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.zip',
            'config' => [
                'type' => 'input',
                'size' => 5,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'city' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.city',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'phone' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.phone',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'mobile' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.mobile',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'fax' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.fax',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'link' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.link',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim',
                'wizards' => [
                    '_PADDING' => 2,
                    'link' => [
                        'type' => 'popup',
                        'title' => 'Link',
                        'icon' => 'link_popup.gif',
                        'module' => [
                            'name' => 'wizard_element_browser',
                            'urlParameters' => [
                                'mode' => 'wizard'
                            ]
                        ],
                        'JSopenParams' => 'height=350,width=550,status=0,menubar=0,scrollbars=1',
                    ],
                ],
                'softref' => 'typolink',
            ],
        ],
        'mail' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.mail',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'twitter' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.twitter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'facebook' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.facebook',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'xing' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.xing',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'linkedin' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.linkedin',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'custom1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom1',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'custom2' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom2',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'custom3' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.custom3',
            'config' => [
                'type' => 'input',
                'size' => 10,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'map_lng' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.map_lng',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'map_lat' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.map_lat',
            'config' => [
                'type' => 'input',
                'size' => 15,
                'max' => 255,
                'eval' => 'trim'
            ],
        ],
        'image' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.image',
            'config' => [
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder' => 'uploads/tx_mhdirectory',
                'show_thumbs' => 1,
                'size' => 5,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
                'minitems' => 0,
                'maxitems' => 5
            ],
        ],
        'last_calls' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.last_calls',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ],
        ],
        'description' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.description',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ],
        ],
        'opening' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.opening',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ],
        ],
        'count_clicks' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_clicks',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_views' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_views',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_link' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_link',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_twitter' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_twitter',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_facebook' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_facebook',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_xing' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_xing',
            'config' => [
                'type' => 'none',
            ],
        ],
        'count_linkedin' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.count_linkedin',
            'config' => [
                'type' => 'none',
            ],
        ],
        'categories' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_entries.categories',
            'config' => [
                'type' => 'select',
                'foreign_table' => 'sys_category',
                'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.sorting ASC',
                'MM' => 'tx_mhdirectory_entries__mm',
                'size' => 10,
                'autoSizeMax' => 50,
                'maxitems' => 9999,
                'renderMode' => 'tree',
                'treeConfig' => [
                    'parentField' => 'parent',
                    'appearance' => [
                        'expandAll' => true,
                        'showHeader' => true,
                    ],
                ],
            ],
        ],
    ],
'types' => [
    '1' => [
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
                        '],
],
'palettes' => [
    '1' => ['showitem' => 'forename, middlename, lastname', 'canNotCollapse' => 1],
    '2' => ['showitem' => 'zip, city', 'canNotCollapse' => 1],
    '3' => ['showitem' => 'relation_state, relation_district, relation_city', 'canNotCollapse' => 1],
    '4' => ['showitem' => 'phone, mobile, fax', 'canNotCollapse' => 1],
    '5' => ['showitem' => 'map_lat, map_lng', 'canNotCollapse' => 1],
],
];
