<?php

$EM_CONF[$_EXTKEY] = array (
	'title' => 'MH-Directory',
	'description' => 'Next-Generation of mh_branchenbuch. Generate a powerfull directory for your needs! Import old entries from mh_branchenbuch; Alphabetical-Menu; List-Function; Country-Based-List (Federal State, Administrative District, City); Define your own types for every Entry (Enable or disable features) and much more ... active development on GitHub!',
	'category' => 'fe',
	'version' => '0.7.0',
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
			'typo3' => '6.0.0-7.99.99'
		),
		'conflicts' => array (),
		'suggests' => array (),
	),
);

