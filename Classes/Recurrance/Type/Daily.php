<?php 

/**
 * daily recurrance
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Type_Daily extends Tx_CzSimpleCal_Recurrance_Type_Base {
	
	/**
	 * the main method building the recurrance
	 * 
	 * @return void
	 */
	protected function doBuild() {
		
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		while(true) {
			
			if($until < $start) {
				break;
			}
			
			$this->timeline->add(
				array(
					'start' => $start->getTimestamp(),
					'end'   => $end->getTimestamp()
				)
			);
			
			$start->modify('+1 day');
			$end->modify('+1 day');
		}
	}
	
}