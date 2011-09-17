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
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_DateValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'startDay',
		
			'required' => true,
			'minimum' => Tx_CzSimpleCal_Utility_StrToTime::strtotime('midnight')
		));
		$this->addPropertyValidator('startDay', $validator);
		
		// startTime
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_TimeValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'startTime',
		
			'required' => false
		));
		$this->addPropertyValidator('startTime', $validator);
		
		// endDay
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_DateValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'endDay',
		
			'required' => false,
			'minimum' => Tx_CzSimpleCal_Utility_StrToTime::strtotime('midnight')
		));
		$this->addPropertyValidator('endDay', $validator);
		
		// endTime
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_TimeValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'endTime',
		
			'required' => false
		));
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
		$andValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_ConjunctionValidator');
			$stringValidator = $this->getObjectManager()->get('Tx_Extbase_Validation_Validator_StringLengthValidator');
			$stringValidator->setOptions(array('minimum' => 10, 'maximum' => 255));
			$andValidator->addValidator($stringValidator);
			$urlValidator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_UrlValidator');
			$urlValidator->setOptions(array(
				'object' => $value,
				'propertyName' => 'showPageInstead'
			));
			$andValidator->addValidator($urlValidator);
		$validator->addValidator($andValidator);
		$validator->addValidator($this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_EmptyValidator'));
		$this->addPropertyValidator('showPageInstead', $validator);
		
		// twitterHashtags
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_TwitterHashtagValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'twitterHashtags',

			'required' => false,
		));
		$this->addPropertyValidator('twitterHashtags', $validator);
		
		
		// flickrTags
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_FlickrTagValidator');
		$validator->setOptions(array(
			'object' => $value,
			'propertyName' => 'flickrTags',

			'required' => false,
		));
		$this->addPropertyValidator('flickrTags', $validator);
		
		$isValid = parent::isValid($value);
		
		// check: event does not end before it starts
		if($value->getDateTimeObjectStart()->getTimestamp() > $value->getDateTimeObjectEnd()->getTimestamp()) {
			$this->addError('This event is not allowed to start before it ends.', 1316261470);
			$isValid = false;
		}
		
		// prevent descriptions from having tags (will be parsed with parsefunc_RTE
		$value->setDescription(htmlspecialchars($value->getDescription(), null, null, false));
		
		return $isValid;
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