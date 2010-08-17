<?php 

/**
 * no recurrance at all - only this single event
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Type_None extends Tx_CzSimpleCal_Recurrance_Type_Base {
	
	/**
	 * the main method building the recurrance
	 * 
	 * @return void
	 */
	protected function doBuild() {
		$this->timeline->add(array(
			'start' => $this->event->getDateTimeObjectStart()->getTimestamp(),
			'end'   => $this->event->getDateTimeObjectEnd()->getTimestamp(),
		));
	}
	
}