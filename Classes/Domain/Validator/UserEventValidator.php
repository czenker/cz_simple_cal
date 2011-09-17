<?php 

/**
 * validates an event submitted by a user
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Validator_UserEventValidator extends Tx_Extbase_Validation_Validator_GenericObjectValidator {
	
	/**
	 * validate an Event submitted by the user
	 * 
	 * @return bool
	 */
	public function isValid($value) {
		
		// title
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$validator->setOptions(array('minimum' => 3, 'maximum' => 255));
		$this->addPropertyValidator('title', $validator);
		
		// startDay
		$this->addPropertyValidator('startDay', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		
		// startTime
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$validator->addValidator($this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('startTime', $validator);
		
		// endDay
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$validator->addValidator($this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('endDay', $validator);
		
		// endTime
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$validator->addValidator($this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('endTime', $validator);
		
		// description
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_NoTagsValidator'));
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('description', $validator);
		
		// locationName
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$stringValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$stringValidator->setOptions(array('minimum' => 3, 'maximum' => 255));
		$validator->addValidator($stringValidator);
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('locationName', $validator);
		
		// locationAddress
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$stringValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$stringValidator->setOptions(array('minimum' => 3, 'maximum' => 255));
		$validator->addValidator($stringValidator);
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('locationAddress', $validator);
		
		// locationCity
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$stringValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$stringValidator->setOptions(array('minimum' => 3, 'maximum' => 255));
		$validator->addValidator($stringValidator);
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('locationCity', $validator);
		
		// showPageInstead
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_DisjunctionValidator');
		$stringValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$stringValidator->setOptions(array('minimum' => 10, 'maximum' => 255));
		$validator->addValidator($stringValidator);
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('showPageInstead', $validator);
		
		return parent::isValid($value);
	}
	
			
	protected $objectManager = null;
	
	/**
	 * @return Tx_Extbase_Object_ObjectManager
	 */
	protected function getObjectManager() {
		if(is_null($this->objectManager)) {
			$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		}
		return $this->objectManager;
	}
	
	
}

?>