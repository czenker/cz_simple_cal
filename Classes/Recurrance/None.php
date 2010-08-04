<?php 

/**
 * no recurrance at all - only this single event
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_None extends Tx_CzSimpleCal_Recurrance_Base {
	
	protected function doBuild() {
		$this->collection->add(array(
			'start' => $this->event->getDateTimeObjectStart()->getTimestamp(),
			'end'   => $this->event->getDateTimeObjectEnd()->getTimestamp(),
		));
	}
	
}