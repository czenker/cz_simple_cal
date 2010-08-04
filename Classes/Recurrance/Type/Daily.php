<?php 

/**
 * daily recurrance
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Type_Daily extends Tx_CzSimpleCal_Recurrance_Type_Base {
	
	protected function doBuild() {
		
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		t3lib_div::devLog('recurrance_daily', 'cz_simple_cal', 0, array(
			'start' => $start->format('Y-m-d H:i:se'),
			'end' => $end->format('Y-m-d H:i:se'),
			'until' => $until->format('Y-m-d H:i:se')
		));
		
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