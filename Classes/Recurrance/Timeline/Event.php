<?php

/**
 * holds multiple EventIndices for the same Event
 *
 * to keep it lightweight, when creating EventIndices from Events
 * they are not instanciated as objects, but are represented by an array.
 *
 * This class manages these arrays and takes care of a valid syntax.
 *
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Timeline_Event extends Tx_CzSimpleCal_Recurrance_Timeline_Base {
	
	/**
	 * the id of the Event this collection belongs to
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $event = null;


	/**
	 * set the id of the Event this collection belongs to
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function setEvent($event) {
		$this->event = $event;
		return $this;
	}
	
	/**
	 * add the model id to an EventIndex
	 * 
	 * @param array $array
	 * @return array
	 */
	protected function addEvent($array){
		$array['event'] = $this->event;
		$array['pid'] = $this->event->getPid();
		return $array;
	}
	
	public function current() {
		$this->initOutput();
		return $this->addEvent(current($this->data));
	}

	public function next() {
		$this->initOutput();
		if($this->nextAsCurrent) {
			$this->nextAsCurrent = false;
			return $this->addEvent(current($this->data));
		}
		return $this->addEvent(next($this->data));
	}

}