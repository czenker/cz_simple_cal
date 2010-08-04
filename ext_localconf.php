<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Event' => 'list,show',
		'Category' => 'show',
	),
	array(
	)
);

//$extutil = new Tx_Extbase_Utility_Extension();
//file_put_contents('/var/www/dom/foobar',$extutil->createAutoloadRegistryForExtension($_EXTKEY, t3lib_extMgm::extPath($_EXTKEY)));
?>