<?php 

abstract class Tx_CzSimpleCal_Indexer_Base {

	/**
	 * the main method that does the indexing of an event if required
	 * 
	 * @param integer $id
	 * @param array $fieldsArray
	 * @param boolean $update did the record already exist 
	 * @return void
	 */
	abstract public function index($id, $fieldsArray, $update = true);
	
	/**
	 * check if fields have been changed in the record 
	 * 
	 * @param $fields
	 * @return boolean
	 */
	protected function haveFieldsChanged($fields) {
		$criticalFields = array_intersect(
			array_keys($this->fieldsArray),
			$fields
		);
		return !empty($criticalFields);
	}
	
}