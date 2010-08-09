<?php 

class Tx_CzSimpleCal_Scheduler_Index extends tx_scheduler_Task {
	
	public function execute() {
		t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
		
		$eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		
		t3lib_div::devLog('Hello World Task', 'cz_simple_cal', 0, $eventRepository->findAllEverywhere());
		
		
		
		
		return true;
	}
	
}