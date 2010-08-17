<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_czsimplecal_domain_model_exception'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_exception']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,day,recurrance_type,recurrance_subtype,recurrance_until'
	),
	'types' => array(
		'1' => array('showitem' => 'title,day,recurrance_type,recurrance_subtype,recurrance_until')
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
		'title' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'day' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.day',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'date,required',
			)
		),
		'timezone' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.timezone',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'max' => 40,
				'eval' => 'string',
				'default' => 'GMT'
			)
		),
		'recurrance_type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.recurrance_type',
			'config'  => array(
				'type' => 'select',
				'items' => array(
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.recurrance_type.none',
						'none'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.recurrance_type.daily',
						'daily'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.recurrance_type.weekly',
						'weekly'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.recurrance_type.monthly',
						'monthly'
					),
					
				),
			)
		),
		'recurrance_until' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_until',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'date',
				'checkbox' => '-1',
				'default' => '-1'
			)
		),
		'recurrance_subtype' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_subtype',
			'displayCond' => 'FIELD:recurrance_type:!IN:none,daily',
			'config'  => array(
				'type' => 'select',
				'itemsProcFunc' => 'EXT:cz_simple_cal/Legacy/class.tx_czsimplecal_dynFlexform.php:tx_czsimplecal_dynFlexform->getRecurranceSubtype'
			)
		),
		'events' => array(
			'label' => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.events',
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
		
		'exception_groups' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_exception.exception_events',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'tx_czsimplecal_domain_model_exceptiongroup',
				'MM' => 'tx_czsimplecal_exceptiongroup_exception_mm',
				'MM_opposite_field' => 'exceptions',
				'maxitems' => 99999,
				'size' => 5,
				'autoSizeMax' => 20
			)
		),
	),
);
?>