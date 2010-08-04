<?php 

abstract class Tx_CzSimpleCal_Recurrance_Base {
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $event = null;
	
	/**
	 * @var Tx_CzSimpleCal_Collection_EventIndex
	 */
	protected $collection = null;
	
	/**
	 * build all recurrant events from an Event
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_Event  $event
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function build($event) {
		$this->event = $event;
		$this->collection = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Collection_EventIndex');
		$this->collection->setEvent($event);
	
		$this->doBuild();
		
		return $this->collection;
	}
	
	abstract protected function doBuild();
	
}