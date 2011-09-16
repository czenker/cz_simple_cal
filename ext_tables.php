<?php
if (!defined ('TYPO3_MODE')) die ('Access denied.');

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'Simple calendar using Extbase'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi2',
	'Calendar event submission for users'
);

//if(TYPO3_MODE === 'BE') {
//	Tx_Extbase_Utility_Extension::registerModule(
//		$_EXTKEY,
//		'web',
//		'tx_czsimplecal_m1',
//		'',
//		array(
//			'Event' => 'backendIndex'
//		),
//		array(
//			'access' => 'user,group',
//			'icon' => 'EXT:cz_simple_cal/ext_icon.gif',
//			'labels' => 'LLL:EXT:'.$_EXTKEY.'/Resources/Private/Language/locallang_mod.xml'
//		)
//	);
//	
//}

// default typoscript
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/main', 'Simple calendar using Extbase');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/customaddress', 'Use custom address extension');
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/ics', 'ICS configuration');

// init flexform for plugin
$TCA['tt_content']['types']['list']['subtypes_addlist']['czsimplecal_pi1'] = 'pi_flexform';
$TCA['tt_content']['types']['list']['subtypes_excludelist']['czsimplecal_pi1'] = 'layout,select_key';
t3lib_extMgm::addPiFlexFormValue('czsimplecal_pi1', 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform.xml');

// hook into the post storing process to update the index of recurring events
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:'.$_EXTKEY.'/Legacy/class.tx_czsimplecal_getDatamapHook.php:tx_czsimplecal_getDatamapHook';
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass'][] = 'EXT:'.$_EXTKEY.'/Legacy/class.tx_czsimplecal_getCmdmapHook.php:tx_czsimplecal_getCmdmapHook';


// TCA config
t3lib_extMgm::addLLrefForTCAdescr('tx_czsimplecal_domain_model_event','EXT:cz_simple_cal/Resources/Private/Language/locallang_csh_tx_czsimplecal_domain_model_event.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_czsimplecal_domain_model_event');
$TCA['tx_czsimplecal_domain_model_event'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event',
		'label'             => 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'default_sortby'    => 'ORDER BY start_day DESC, start_time DESC',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dividers2tabs' => 1,
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Event.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_event.gif'
	)
);

$TCA['tx_czsimplecal_domain_model_eventindex'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event',
		'label' 			=> '',
		'hideTable'         => true,
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/EventIndex.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_event_index.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_czsimplecal_domain_model_exception','EXT:cz_simple_cal/Resources/Private/Language/locallang_csh_tx_czsimplecal_domain_model_exception.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_czsimplecal_domain_model_exception');
$TCA['tx_czsimplecal_domain_model_exception'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception',
		'label' 			=> 'title',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Exception.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_exception.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_czsimplecal_domain_model_exceptiongroup','EXT:cz_simple_cal/Resources/Private/Language/locallang_csh_tx_czsimplecal_domain_model_exceptiongroup.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_czsimplecal_domain_model_exceptiongroup');
$TCA['tx_czsimplecal_domain_model_exceptiongroup'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exceptiongroup',
		'label' 			=> 'title',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/ExceptionGroup.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_exceptiongroup.gif'
	)
);

t3lib_extMgm::addLLrefForTCAdescr('tx_czsimplecal_domain_model_category','EXT:cz_simple_cal/Resources/Private/Language/locallang_csh_tx_czsimplecal_domain_model_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_czsimplecal_domain_model_category');
$TCA['tx_czsimplecal_domain_model_category'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_category',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_category.gif'
	)
);

$TCA['tx_czsimplecal_domain_model_address'] = array (
	'ctrl' => array (
		'title'             => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_address',
		'label' 			=> 'name',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l18n_parent',
		'transOrigDiffSourceField' 	=> 'l18n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden'
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Address.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_czsimplecal_domain_model_address.gif'
	)
);

?>