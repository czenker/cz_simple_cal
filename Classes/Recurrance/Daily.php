<?php 

/**
 * daily recurrance
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Daily extends Tx_CzSimpleCal_Recurrance_Base {
	
	protected function doBuild() {
		
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		while(true) {
			
			if($until < $start) {
				break;
			}
			
			$data = array(
				'start' => $start->getTimestamp(),
				'end'   => $end->getTimestamp()
			);
			
			t3lib_div::devLog('recurrance', 'cz_simple_cal', 2, $data);
			
			$this->collection->add(
				$data
			);
			
			$start->modify('+1 day');
			$end->modify('+1 day');
		}
	}
	
}