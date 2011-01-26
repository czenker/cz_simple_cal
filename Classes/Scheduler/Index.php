<?php 

/**
 * the scheduler task to index all events
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Scheduler_Index extends tx_scheduler_Task {
	
	/**
	 * execute this task
	 * 
	 * @return boolean
	 */
	public function execute() {
		
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		
		$eventRepository = $objectManager->get('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$indexer = $objectManager->get('Tx_CzSimpleCal_Indexer_Event');
		
		foreach($eventRepository->findAllEverywhere() as $event) {
			$indexer->update($event);
		}
		
		return true;
	}
	
}