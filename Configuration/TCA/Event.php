<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_czsimplecal_domain_model_event'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,start_day,start_time,end_day,end_time,teaser,description,recurrance_type,recurrance_until,recurrance_times,location_name,organizer_name,category'
	),
	'types' => array(
		'1' => array('showitem' => 'title,start_day,start_time,end_day,end_time,teaser,description;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],recurrance_type,recurrance_until,recurrance_times,location_name,organizer_name,category')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.php:LGL.allLanguages',-1),
					array('LLL:EXT:lang/locallang_general.php:LGL.default_value',0)
				)
			)
		),
		'l18n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_czsimplecal_domain_model_event',
				'foreign_table_where' => 'AND tx_czsimplecal_domain_model_event.uid=###REC_FIELD_l18n_parent### AND tx_czsimplecal_domain_model_event.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array(
			'config'=>array(
				'type'=>'passthrough')
		),
		't3ver_label' => array(
			'displayCond' => 'FIELD:t3ver_label:REQ:true',
			'label' => 'LLL:EXT:lang/locallang_general.php:LGL.versionLabel',
			'config' => array(
				'type'=>'none',
				'cols' => 27
			)
		),
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
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			)
		),
		'start_day' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.start_day',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'date,required',
			)
		),
		'start_time' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.start_time',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'time',
				'checkbox' => '-1',
				'default' => '-1'
			)
		),
		'end_day' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.end_day',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'date',
				'checkbox' => '-1',
				'default' => '-1'
			)
		),
		'end_time' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.end_time',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'time',
				'checkbox' => '-1',
				'default' => '-1'
			)
		),
		'timezone' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.timezone',
			'config'  => array(
				'type' => 'input',
				'size' => 40,
				'max' => 40,
				'eval' => 'string',
				'default' => 'GMT'
			)
		),
		'teaser' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.teaser',
			'config'  => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 6,
				'eval' => 'trim'
			)
		),
		'description' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.description',
			'config' => array (
				'type' => 'text',
				'cols' => 40,	   
				'rows' => 6,
				'wizards' => array(
					'_PADDING' => 4,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'LLL:EXT:cms/locallang_ttc.php:bodytext.W.RTE',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				)
			)
		),
		'recurrance_type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type',
			'config'  => array(
				'type' => 'select',
				'items' => array(
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.none',
						'none'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.weekly',
						'weekly'
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
//		'recurrance_times' => array(
//			'exclude' => 1,
//			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_times',
//			'config'  => array(
//				'type' => 'input',
//				'size' => 4,
//				'max' => 4,
//				'eval' => 'int',
//				'checkbox' => '0',
//				'default' => '0'
//			)
//		),
		'location_name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'organizer_name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'category' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.category',
			'config'  => array(
				'type' => 'inline',
				'foreign_table' => 'tx_czsimplecal_domain_model_category',
				'MM' => 'tx_czsimplecal_event_category_mm',
				'maxitems' => 99999
			)
		),
	),
);
?>