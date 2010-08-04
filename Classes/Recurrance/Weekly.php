<?php 

/**
 * no recurrance at all - only this single event
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Weekly extends Tx_CzSimpleCal_Recurrance_Base {
	
	protected function doBuild() {
		
		$weeks = 0;
		
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		while(true) {
			
			if($until < $start || $weeks > 999) {
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
			
			$start->modify('+1 week');
			$end->modify('+1 week');
			
		}
	}
	
}