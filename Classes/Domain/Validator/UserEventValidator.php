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
//		$this->addPropertyValidator('title', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_NotEmptyValidator'));
		$validator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
		$validator->setOptions(array('minimum' => 3, 'maximum' => 255));
		$this->addPropertyValidator('title', $validator);
		
		$this->addPropertyValidator('startDay', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		
		if($value->getStartTime()) {
			$this->addPropertyValidator('startTime', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		}
		
		if($value->getEndDay()) {
			$this->addPropertyValidator('endDay', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		}
		
		if($value->getEndTime()) {
			$this->addPropertyValidator('endTime', $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_IntegerValidator'));
		}
		
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