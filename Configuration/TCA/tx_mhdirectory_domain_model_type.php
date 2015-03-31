<?php
return array(
    'ctrl' => array(
        'title' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type',
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
        'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('mh_directory') . 'Resources/Public/Icons/tx_mhdirectory_domain_model_type.gif',
        'searchFields' => 'name'
    ),
    'interface' => array(
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, name, price, image, description',
    ),
    'columns' => array(
        'hidden'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.hidden',
            'config' => array(
                'type' => 'check',
                'default' => 0
            ),
        ),   
        'name'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.name',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => 'trim,required'
            ),
        ),         
        'price'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.price',
            'config' => array(
                'type' => 'input',
                'size' => 20,
                'max' => 10,
                'eval' => 'double2'
            ),
        ),        
        'options'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.options',
            'config' => array(
                'type' => 'check',
                'items' => array(
                    array('Detail-Link', ''),
                    array('Image', ''),
                    array('Twitter', ''),
                    array('Facebook', ''),
                    array('Description', ''),
                    array('GoogleMap', ''),
                    array('Mail', ''),
                    array('Link', ''),
                    array('Address (Name, Street, Zip & City)', ''),
                    array('Contact (Phone, mobile & Fax)', ''),
                    array('Custom 1', ''),
                    array('Custom 2', ''),
                    array('Custom 3', ''),
                ),
            ),
        ),        
        'image'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.image',
            'config' => array(
                'type' => 'group',
                'internal_type' => 'file',
                'uploadfolder'  => 'uploads/tx_mhdirectory',
                'show_thumbs' => 1,
                'size' => 1,
                'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
                'disallowed' => '',
                'minitems' => 0,
                'maxitems' => 1
            ),
        ),
        'description'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.description',
            'config' => array(
                'type' => 'text',
                'cols' => 40,
                'rows' => 15
            ),
        ),
        'sorting'   => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:mh_directory/Resources/Private/Language/locallang.xlf:tx_mhdirectory_domain_model_type.sorting',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'max' => 255,
                'eval' => ''
            ),
        ), 
    ),
'types' => array(
    '1' => array(
        'showitem' => 'hidden, name, price, options, image, description'),
),
'palettes' => array(
    '1' => array('showitem' => ''),
),
);