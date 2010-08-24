<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'EventIndex' => 'dispatch',
		'Category' => 'show',
	),
	array(
	)
);

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_CzSimpleCal_Scheduler_Index'] = array(
    'extension'        => $_EXTKEY,
    'title'            => 'Index all events',
    'description'      => 'Indexing all events of czSimpleCal'
);

// add default pageTSConfig
t3lib_extMgm::addPageTSConfig(
	file_get_contents(
		t3lib_extMgm::extPath('cz_simple_cal').'Configuration/TSconfig/default.txt'
	)
);
?>