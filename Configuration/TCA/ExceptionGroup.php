<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_czsimplecal_domain_model_exceptiongroup'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_exceptiongroup']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,exceptions'
	),
	'types' => array(
		'1' => array('showitem' => 'title,exceptions')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array(
				'type' => 'check'
			)
		),
		'title' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exceptiongroup.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'exceptions' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exceptiongroup.exceptions',
			'config'  => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_czsimplecal_domain_model_exception',
//				'foreign_table' => 'tx_czsimplecal_domain_model_exception',
				'MM' => 'tx_czsimplecal_exceptiongroup_exception_mm',
				'maxitems' => 99999,
				'size' => 5,
				'autoSizeMax' => 20
			)
		),
		
		'events' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exceptiongroup.events',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_czsimplecal_domain_model_event',
				'MM' => 'tx_czsimplecal_event_exception_mm',
				'MM_opposite_field' => 'exceptions',
				'maxitems' => 99999,
				'size' => 5,
				'autoSizeMax' => 20
			)
		),
	),
);
?>