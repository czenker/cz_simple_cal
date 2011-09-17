<?php 

/**
 * sanitizes and validates a given date
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_DateValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
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
			$value = intval($value);
		} else {
			$day = Tx_CzSimpleCal_Utility_StrToTime::strtotime($value.' | 00:00');
			if($day === false) {
				$this->addError('could not be parsed.', 'parseError');
				return false;
			} else {
				$object->{$setterMethodName}($day);
				$value = $day;
			}
		}
		
		// minimum
		if($this->options['minimum']) {
			if($value < $this->options['minimum']) {
				$this->addError(sprintf('No dates before %s allowed.', strftime('%Y-%m-%d', $this->options['minimum'])), 'minimum');
				return false;
			}
		}

		// maximum
		if($this->options['maximum']) {
			if($value > $this->options['maximum']) {
				$this->addError(sprintf('No dates after %s allowed.', strftime('%Y-%m-%d', $this->options['maximum'])), 'maximum');
				return false;
			}
		}
		
		return true;
		
	}
	
	
}

?>