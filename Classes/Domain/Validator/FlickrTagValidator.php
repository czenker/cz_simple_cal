<?php 

/**
 * sanitizes and validates a list of flickr tags
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_FlickrTagValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
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

		$tags = t3lib_div::trimExplode(',', $value);
		if($this->options['minimum'] && $this->options['minimum'] > count($tags)) {
			$this->addError(sprintf('at least %d items required', $this->options['minimum']), 'minimum');
			return false;
		}
		
		if($this->options['maximum'] && $this->options['maximum'] > count($tags)) {
			$this->addError(sprintf('at max %d items allowed', $this->options['maximum']), 'maximum');
			return false;
		}
		
		foreach($tags as &$tag) {
			if(!preg_match('/^[\pL\pN\-]{2,40}$/i', $tag)) {
				$this->addError(sprintf('"%s" is not a valid tag.', $tag), 'invalid');
				return false;
			}
		}
		
		$value = implode(', ', $tags);
		
		$object->{$setterMethodName}($value);
		return true;
	}
	
	
}

?>