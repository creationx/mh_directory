<?php

$EM_CONF[$_EXTKEY] = array (
	'title' => 'MH-Directory',
	'description' => '',
	'category' => 'plugin',
	'version' => '0.5.2',
	'state' => 'beta',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_mhdirectory',
	'clearcacheonload' => 0,
	'author' => 'Martin Hesse',
	'author_email' => 'info@mh-dev.de',
	'author_company' => 'MH-Dev. - Webentwicklung',
	'constraints' => 
	array (
		'depends' => array (
			'php' => '5.3.7-0.0.0',
			'typo3' => '6.0.0-7.1.99',
			'vhs' => '2.3.0-0.0.0'
		),
		'conflicts' => array (),
		'suggests' => array (),
	),
);

