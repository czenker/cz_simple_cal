<?php 

/**
 * checks that a value is null or ''
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_EmptyValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	/**
	 * checks that a value is null or ''
	 * 
	 * @return bool
	 */
	public function isValid($value) {
		$this->errors = array();
		
		if(is_null($value) || $value === '') {
			return TRUE;
		}
	
		$this->addError('This value should be empty.', 1316198501);
		return FALSE;
	}
	
}

?>