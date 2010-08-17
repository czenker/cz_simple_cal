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
	 * @param Tx_CzSimpleCal_Domain_Interface_HasTimespan  $hasTimespan
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function build(Tx_CzSimpleCal_Domain_Interface_HasTimespan $event, $timeline) {
		$this->event = $event;
		$this->timeline = $timeline;
	
		$this->doBuild();
		
		return $this->timeline;
	}
	
	
}