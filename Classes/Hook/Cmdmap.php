<?php 

class Tx_CzSimpleCal_Hook_Cmdmap {
	/**
	 * implements the hook processCmdmap_postProcess
	 * 
	 * @param unknown_type $command
	 * @param unknown_type $table
	 * @param unknown_type $id
	 * @param unknown_type $value
	 * @param unknown_type $tce
	 */
	public function processCmdmap_postProcess($command, $table, $id, $value, $tce) {
		t3lib_div::devLog(sprintf('%s: %s', $table, $command), 'cz_simple_cal');
		if ($table == 'tx_czsimplecal_domain_model_event') {
			//if: an event was changed
			$indexer = t3lib_div::makeInstance('Tx_CzSimpleCal_Indexer_Event');
			
			if($command === 'move') {
				$indexer->update($id);
			} elseif($command === 'delete') {
				$indexer->delete($id);
			} elseif($command === 'undelete') {
				$indexer->create($id);
			}
		}
	}
}