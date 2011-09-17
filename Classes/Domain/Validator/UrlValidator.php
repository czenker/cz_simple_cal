<?php 

/**
 * sanitizes and validates a given url
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_UrlValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	public function isValid($value) {
		$setterMethodName = 'set'.$this->options['propertyName'];
		$getterMethodName = 'get'.$this->options['propertyName'];
		$object = $this->options['object'];
		
		// check that value and domain property match
		if($value != $object->{$getterMethodName}()) {
			throw new RuntimeException('the given value and the value of the object don\'t match in '.get_class($this));
		}
		
		if(empty($value)) {
			return true;
		}
		
		if(strpos($value, '://') === false) {
			$value = 'http://'.$value;
		}
		
		$value = filter_var($value, FILTER_VALIDATE_URL);
		
		if($value === false) {
			$this->addError('The url does not seem valid.','invalid');
			return false;
		} 
		
		$object->{$setterMethodName}($value);
		return true;
	}
	
	
}

?>