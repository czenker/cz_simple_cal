<?php 

abstract class Tx_CzSimpleCal_Recurrance_Type_Base {
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Interface_HasTimespan
	 */
	protected $event = null;
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Timeline_Base
	 */
	protected $timeline = null;
	
	/**
	 * build all recurrant events from an Event
	 * 
	 * @param Tx_CzSimpleCal_Domain_Interface_HasTimespan $event
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function build(Tx_CzSimpleCal_Domain_Interface_HasTimespan $event, $timeline) {
		$this->event = $event;
		$this->timeline = $timeline;
	
		$this->doBuild();
		
		return $this->timeline;
	}
	
	/**
	 * add locallang labels to an array of subtypes
	 * 
	 * @param array $values
	 * @param string $base the locallang base
	 */
	protected static function addLL($values, $base = 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_db.xml:tx_czsimplecal_domain_model_event.recurrance_subtype.') {
		foreach($values as &$value) {
			$value = array(
				$GLOBALS["LANG"]->sL($base.$value),
				$value,
			);
		}
		return $values;
	}
	
}