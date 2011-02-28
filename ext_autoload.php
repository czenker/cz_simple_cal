<?php

$extensionClassesPath = t3lib_extMgm::extPath('cz_simple_cal') . 'Classes/';
return array(
	//needed by the scheduler
	'tx_czsimplecal_scheduler_index' => $extensionClassesPath . 'Scheduler/Index.php',
	//needed for hooks
	'tx_czsimplecal_indexer_event' => $extensionClassesPath . 'Indexer/Event.php',
	'tx_czsimplecal_hook_datamap' => $extensionClassesPath . 'Hook/Datamap.php',
	'tx_czsimplecal_hook_cmdmap' => $extensionClassesPath . 'Hook/Cmdmap.php',

	'tx_czsimplecal_utility_flexconfig' => $extensionClassesPath . 'Utility/FlexConfig.php',
	

	//needed for tests
	'tx_czsimplecal_test_baseseleniumtestcase' => t3lib_extMgm::extPath('cz_simple_cal') . 'Tests/BaseSeleniumTestCase.php',


	/**
	 * 
	 * quickfix. The pre-save hook of records could not find the repository
	 * the new dispatcher and DI should fix this later on.
	 * 
	 * @todo remove this if no longer needed
	 */ 
	'tx_czsimplecal_domain_repository_eventrepository' => $extensionClassesPath . 'Domain/Repository/EventRepository.php',
	'tx_czsimplecal_domain_repository_eventindexrepository' => $extensionClassesPath . 'Domain/Repository/EventIndexRepository.php',
	'tx_czsimplecal_domain_repository_categoryrepository' => $extensionClassesPath . 'Domain/Repository/CategoryRepository.php',
	'tx_czsimplecal_domain_repository_exceptionrepository' => $extensionClassesPath . 'Domain/Repository/ExceptionRepository.php',
	
	'tx_czsimplecal_domain_model_base' => $extensionClassesPath . 'Domain/Model/Base.php',
	'tx_czsimplecal_domain_model_baseaddress' => $extensionClassesPath . 'Domain/Model/BaseAddress.php',
	'tx_czsimplecal_domain_model_baseevent' => $extensionClassesPath . 'Domain/Model/BaseEvent.php',
	'tx_czsimplecal_domain_model_category' => $extensionClassesPath . 'Domain/Model/Category.php',
	'tx_czsimplecal_domain_model_event' => $extensionClassesPath . 'Domain/Model/Event.php',
	'tx_czsimplecal_domain_model_eventindex' => $extensionClassesPath . 'Domain/Model/EventIndex.php',
	'tx_czsimplecal_domain_model_exception' => $extensionClassesPath . 'Domain/Model/Exception.php',
	'tx_czsimplecal_domain_model_exceptiongroup' => $extensionClassesPath . 'Domain/Model/ExceptionGroup.php',
	'tx_czsimplecal_domain_model_location' => $extensionClassesPath . 'Domain/Model/Location.php',
	'tx_czsimplecal_domain_model_organizer' => $extensionClassesPath . 'Domain/Model/Organizer.php',
	
	'tx_czsimplecal_domain_interface_hastimespan' => $extensionClassesPath . 'Domain/Interface/HasTimespan.php',
	'tx_czsimplecal_domain_interface_isrecurring' => $extensionClassesPath . 'Domain/Interface/IsRecurring.php',

	'tx_czsimplecal_recurrance_factory' => $extensionClassesPath . 'Recurrance/Factory.php',
	'tx_czsimplecal_recurrance_type_base' => $extensionClassesPath . 'Recurrance/Type/Base.php',
	'tx_czsimplecal_recurrance_type_daily' => $extensionClassesPath . 'Recurrance/Type/Daily.php',
	'tx_czsimplecal_recurrance_type_monthly' => $extensionClassesPath . 'Recurrance/Type/Monthly.php',
	'tx_czsimplecal_recurrance_type_none' => $extensionClassesPath . 'Recurrance/Type/None.php',
	'tx_czsimplecal_recurrance_type_weekly' => $extensionClassesPath . 'Recurrance/Type/Weekly.php',
	'tx_czsimplecal_recurrance_type_yearly' => $extensionClassesPath . 'Recurrance/Type/Yearly.php',

	'tx_czsimplecal_recurrance_timeline_base' => $extensionClassesPath . 'Recurrance/Timeline/Base.php',
	'tx_czsimplecal_recurrance_timeline_event' => $extensionClassesPath . 'Recurrance/Timeline/Event.php',
	'tx_czsimplecal_recurrance_timeline_exception' => $extensionClassesPath . 'Recurrance/Timeline/Exception.php',

	'tx_czsimplecal_utility_config' => $extensionClassesPath . 'Utility/Config.php',
	'tx_czsimplecal_utility_datetime' => $extensionClassesPath . 'Utility/DateTime.php',
	'tx_czsimplecal_utility_eventconfig' => $extensionClassesPath . 'Utility/EventConfig.php',
	'tx_czsimplecal_utility_flexconfig' => $extensionClassesPath . 'Utility/FlexConfig.php',
	'tx_czsimplecal_utility_inflector' => $extensionClassesPath . 'Utility/Inflector.php',
	'tx_czsimplecal_utility_strtotime' => $extensionClassesPath . 'Utility/StrToTime.php',
	
);
?>