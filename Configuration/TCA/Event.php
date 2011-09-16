<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_czsimplecal_domain_model_event'] = array(
	'ctrl' => $TCA['tx_czsimplecal_domain_model_event']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'title,start_day,start_time,end_day,end_time,teaser,description,slug,recurrance_type,recurrance_subtype,recurrance_until,location_name,location,organizer_name,organizer,categories,show_page_instead,exceptions,flickr_tags,twitter_hashtags'
	),
	'types' => array(
		'1' => array('showitem' => '--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_general,title,start_day,start_time,end_day,end_time,categories,show_page_instead,teaser,description;;;richtext:rte_transform[flag=rte_enabled|mode=ts_css],--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_resources,images;;2,files;;3,slug,--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_recurrance,recurrance_type,recurrance_subtype,recurrance_until,exceptions,--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_location,location_name,location_address,location_zip,location_city,location_country,location,--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_organizer,organizer_name,organizer_address,organizer_zip,organizer_city,organizer_country,organizer,--div--;LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.tab_socialmedia,twitter_hashtags,flickr_tags')
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
		'2' => array('showitem' => 'images_caption,images_alternative'),
		'3' => array('showitem' => 'files_caption'),
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
		'deleted' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.deleted',
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
		'images' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.images',
			'config'  => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => 10240,
				'uploadfolder' => 'uploads/pics',
				'show_thumbs' => 1,
				'size' => 2,
				'autoSizeMax' => 10,
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'images_caption' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.images_caption',
			'config'  => array(
				'type' => 'text',
				'cols' => 40,	   
				'rows' => 3,
			)
		),
		'images_alternative' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.images_alternative',
			'config'  => array(
				'type' => 'text',
				'cols' => 40,	   
				'rows' => 3,
			)
		),
		'files' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.files',
			'config'  => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',
				'disallowed' => 'php,php3',
				'max_size' => 10240,
				'uploadfolder' => 'uploads/media',
				'show_thumbs' => 1,
				'size' => 2,
				'autoSizeMax' => 10,
				'minitems' => 0,
				'maxitems' => 10,
			)
		),
		'files_caption' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.files_caption',
			'config'  => array(
				'type' => 'text',
				'cols' => 40,	   
				'rows' => 3,
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
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.daily',
						'daily'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.weekly',
						'weekly'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.monthly',
						'monthly'
					),
					array(
						'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_type.yearly',
						'yearly'
					),
				),
			)
		),
		'recurrance_subtype' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_subtype',
			'displayCond' => 'FIELD:recurrance_type:!IN:0,,none,daily',
			'config'  => array(
				'type' => 'select',
				'itemsProcFunc' => 'EXT:cz_simple_cal/Legacy/class.tx_czsimplecal_dynEventForm.php:tx_czsimplecal_dynEventForm->getRecurranceSubtype'
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
		'location' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location',
			'config' => Array (
				'type' => 'group',
				'internal_type' => 'db',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'allowed' => t3lib_extMgm::isLoaded('tt_address') ? 'tt_address' : 'tx_czsimplecal_domain_model_address',
			)
		),
		'location_name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255,
			)
		),
		'location_address' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_address',
			'config'  => array(
				'type' => 'text',
			)
		),
		'location_zip' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_zip',
			'config'  => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'trim',
				'max' => 12,
			)
		),
		'location_city' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_city',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255,
			)
		),
		'organizer' => array (
			'exclude' => 1,
			'label' => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer',
			'config' => array (
				'type' => 'group',
				'internal_type' => 'db',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'allowed' => t3lib_extMgm::isLoaded('tt_address') ? 'tt_address' : 'tx_czsimplecal_domain_model_address',
			)
		),
		'organizer_name' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_name',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255,
			)
		),
		'organizer_address' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_address',
			'config'  => array(
				'type' => 'text',
			)
		),
		'organizer_zip' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_zip',
			'config'  => array(
				'type' => 'input',
				'size' => 7,
				'eval' => 'trim',
				'max' => 12,
			)
		),
		'organizer_city' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_city',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
				'max' => 255,
			)
		),
		'categories' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.categories',
			'config'  => array(
				'type' => 'select',
				'foreign_table' => 'tx_czsimplecal_domain_model_category',
				'MM' => 'tx_czsimplecal_event_category_mm',
				'size' => 10,
				'maxSize' => 20,
				'maxitems' => 9999
			)
		),
		'show_page_instead' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.show_page_instead',
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
		'exceptions' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.exceptions',
			'config'  => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_czsimplecal_domain_model_exception,tx_czsimplecal_domain_model_exceptiongroup',
//				'foreign_table' => 'tx_czsimplecal_domain_model_exception',
				'MM' => 'tx_czsimplecal_event_exception_mm',
				'maxitems' => 99999,
				'size' => 5,
				'autoSizeMax' => 20
			)
		),
		'twitter_hashtags' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.twitter_hashtags',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'max'  => 255,
				'eval' => 'trim'
			)
		),
		'flickr_tags' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.flickr_tags',
			'config'  => array(
				'type' => 'input',
				'size' => 30,
				'max'  => 255,
				'eval' => 'trim'
			)
		),
		'slug' => array(
			'exclude' => 0,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.slug',
			'config'  => array(
				'type' => 'none', // just show the value - don't make it editable
			)
		),
		'last_indexed' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.last_indexed',
			'config'  => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'date',
			)
		),
		'cruser_fe' => array(
			'exclude' => 1,
			'config' => array(
				'type' => 'none',
			),
		),
	),
);

if(t3lib_extMgm::isLoaded('static_info_tables')) {

	$TCA['tx_czsimplecal_domain_model_event']['columns']['organizer_country'] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.organizer_country',
		'config'  => array(
			'type' => 'select',
			'items' => array (
				array('',0),
			),
			'itemsProcFunc' => 'tx_staticinfotables_div->selectItemsTCA',
			'itemsProcFunc_config' => array (
				'table' => 'static_countries',
				'indexField' => 'cn_iso_3',
				'prependHotlist' => 1,
			),
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	);
	
	$TCA['tx_czsimplecal_domain_model_event']['columns']['location_country'] = array(
		'exclude' => 1,
		'label'   => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.location_country',
		'config'  => array(
			'type' => 'select',
			'items' => array (
				array('',0),
			),
			'itemsProcFunc' => 'tx_staticinfotables_div->selectItemsTCA',
			'itemsProcFunc_config' => array (
				'table' => 'static_countries',
				'indexField' => 'cn_iso_3',
				'prependHotlist' => 1,
			),
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
		)
	);
}

?>