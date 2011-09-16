<?php 

/**
 * checks that a string does not container HTML tags
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_NoTagsValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	/**
	 * checks that a string does not container HTML tags
	 * 
	 * @return bool
	 */
	public function isValid($value) {
		$this->errors = array();
		
		$strippedValue = strip_tags($value);
		
		if(strlen($value) > strlen($strippedValue)) {
			$this->addError('HTML tags are not allowed.', 1316198501);
			return FALSE;
		}
		
		return TRUE;
	}
	
}

?>