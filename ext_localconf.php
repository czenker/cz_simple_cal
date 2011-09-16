<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'EventIndex' => 'dispatch',
		'Event' => 'dispatch',
		'Category' => 'show',
	),
	array(
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi2',
	array(
		'EventAdministration' => 'list,new,create,edit,update,delete',
	),
	array(
		'EventAdministration' => 'list,new,create,edit,update,delete',
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_CzSimpleCal_Scheduler_Index'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.label',
    'description'      => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.description',
	'additionalFields' => 'tx_czsimplecal_scheduler_index'
);

// add default pageTSConfig
t3lib_extMgm::addPageTSConfig(
	file_get_contents(
		t3lib_extMgm::extPath('cz_simple_cal').'Configuration/TSconfig/default.txt'
	)
);
?>