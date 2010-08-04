<?php 

class Tx_CzSimpleCal_Hook_Datamap {

	/**
	 * implements the hook processDatamap_afterDatabaseOperations that gets invoked
	 * when a form in the backend was saved and written to the database.
	 * 
	 * Here we will do the caching of recurring events
	 * 
	 * @param string $status
	 * @param string $table
	 * @param integer $id
	 * @param array $fieldArray
	 * @param t3lib_TCEmain $tce
	 */
	public function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $tce) {

		if ($table == 'tx_czsimplecal_domain_model_event') {
			
			//if: an event was changed
			$obj = t3lib_div::makeInstance('Tx_CzSimpleCal_Indexer_Event');
			
			if($status == 'new') {
				
				$id = $tce->substNEWwithIDs[$id];
			}
			
			$obj->index($id, $fieldArray, $status == 'update');
			
		}
	}
	
	/**
	 * implement the hook processDatamap_postProcessFieldArray that gets invoked
	 * right before a dataset is written to the database
	 * 
	 * @param $status
	 * @param $table
	 * @param $id
	 * @param $fieldArray
	 * @param $tce
	 * @return null
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, &$fieldArray, $tce) {
		
		if($table == 'tx_czsimplecal_domain_model_event' || $table == 'tx_czsimplecal_domain_model_exception') {
			// store the timezone to the database
			$fieldArray['timezone'] = date('T');
		}
	}
	
}