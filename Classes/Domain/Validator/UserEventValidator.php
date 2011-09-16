<?php 

/**
 * validates an event submitted by a user
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_UserEventValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	
	/**
	 * validate an Event submitted by the user
	 * 
	 * @return bool
	 */
	public function isValid($event) {
		if(!$event instanceof Tx_CzSimpleCal_Domain_Model_Event) {
			throw new InvalidArgumentException(get_class($this).' only validates Tx_CzSimpleCal_Domain_Model_Event.');
		}
		$this->errors = array();
		
		//TODO:
		
		return true;
	}
	
	
}

?>