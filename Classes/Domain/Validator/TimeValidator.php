<?php 

/**
 * sanitizes and validates a given date
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_TimeValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	public function isValid($value) {
		$setterMethodName = 'set'.$this->options['propertyName'];
		$getterMethodName = 'get'.$this->options['propertyName'];
		$object = $this->options['object'];
		
		// check that value and domain property match
		if($value != $object->{$getterMethodName}()) {
			throw new RuntimeException('the given value and the value of the object don\'t match in '.get_class($this));
		}
		
		// required
		if(empty($value)) {
			if($this->options['required']) {
				$this->addError('no value given', 'required');
				return false;
			} else {
				return true;
			}
		}
		
		// sanitize input
		if(is_numeric($value) && $value > 0) {
			$object->{$setterMethodName}(intval($value));
		} else {
			if(!preg_match('/^\d{1,2}:\d{1,2}$/', $value)) {
				$this->addError('Please use hh:mm as format.', 'format');
				return false;
			}
			list($hour, $min) = t3lib_div::trimExplode(':', $value);
			if($hour < 0 || $hour > 23) {
				$this->addError('Please use hh:mm as format.', 'format');
				return false;
			}
			if($min < 0 || $min > 59) {
				$this->addError('Please use hh:mm as format.', 'format');
				return false;
			}
			$time = 3600 * $hour + $min * 60;
		}
		
		
		if($time < 0 || $time > 3600 * 24) {
			$this->addError('could not be parsed.', 'parseError');
			return false;
		}
		
		$object->{$setterMethodName}($time);
		return true;
	}
	
	
}

?>