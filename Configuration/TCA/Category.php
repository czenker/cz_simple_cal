<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_czsimplecal_domain_model_category'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_category']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,show_page_instead'
	),
	'types' => array(
		'1' => array('showitem' => 'title,show_page_instead')
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
				'foreign_table' => 'tx_czsimplecal_domain_model_category',
				'foreign_table_where' => 'AND tx_czsimplecal_domain_model_category.uid=###REC_FIELD_l18n_parent### AND tx_czsimplecal_domain_model_category.sys_language_uid IN (-1,0)',
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
		'title' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_category.title',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			)
		),
		'show_page_instead' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_category.show_page_instead',
			'config' => array(
				'eval' => 'trim',
				'max' => 256,
				'size' => 25,
				'softref' => 'typolink',
				'type' => 'input',
		
				'wizards' => array(
					'_PADDING' => 2,
					'link' => array(
						'icon' => 'link_popup.gif',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1',
						'script' => 'browse_links.php?mode=wizard',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:header_link_formlabel',
						'type' => 'popup',
					),
				),
			)
		),
	),
);
?>