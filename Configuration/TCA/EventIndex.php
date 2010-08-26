<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');


/*
 * this TCA is needed to get the Domain Object Mapper of Extbase to work, but this table should not be displayed in the frontend
 */

$TCA['tx_czsimplecal_domain_model_eventindex'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_eventindex']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => ''
	),
	'types' => array(
		'1' => array('showitem' => '')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'pid' => array(
			'exclude' => 0,
			'label' => '',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'pages',
				'minitems' => 1,
				'maxitems' => 1
			)
		),
		'start' => array(
			'exclude' => 0,
			'label'   => '',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime,required'
			)
		),
		'end' => array(
			'exclude' => 0,
			'label'   => '',
			'config'  => array(
				'type' => 'input',
				'eval' => 'datetime,required'
			)
		),
		'event' => array(
			'exclude' => 0,
			'label' => '',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_czsimplecal_domain_model_event',
				'minitems' => 1,
				'maxitems' => 1
			) 
		),
		'slug' => array(
			'exclude' => 0,
			'label'   => '',
			'config'  => array(
				'type' => 'none', // just show the value - don't make it editable
			)
		),
	),
);
?>