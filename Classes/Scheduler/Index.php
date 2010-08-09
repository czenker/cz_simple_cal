<?php 

class Tx_CzSimpleCal_Scheduler_Index extends tx_scheduler_Task {
	
	public function execute() {
		t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
		
		$eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		
		$indexer = t3lib_div::makeInstance('Tx_CzSimpleCal_Indexer_Event');
		
		foreach($eventRepository->findAllEverywhere() as $event) {
			$indexer->update($event);
		}
		
		
		
		
		return true;
	}
	
}