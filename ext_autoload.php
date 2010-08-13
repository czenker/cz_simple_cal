<?php

$extensionClassesPath = t3lib_extMgm::extPath('cz_simple_cal') . 'Classes/';
return array(
	//needed by the scheduler
	'tx_czsimplecal_scheduler_index' => $extensionClassesPath . 'Scheduler/Index.php',
	//need for hooks
	'tx_czsimplecal_indexer_event' => $extensionClassesPath . 'Indexer/Event.php',
	'tx_czsimplecal_hook_datamap' => $extensionClassesPath . 'Hook/Datamap.php',
	'tx_czsimplecal_hook_cmdmap' => $extensionClassesPath . 'Hook/Cmdmap.php',

	//needed for tests
	'tx_czsimplecal_test_baseseleniumtestcase' => t3lib_extMgm::extPath('cz_simple_cal') . 'Tests/BaseSeleniumTestCase.php',
);
?>