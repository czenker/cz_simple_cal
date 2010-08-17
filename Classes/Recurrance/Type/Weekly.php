<?php 

/**
 * weekly recurrance
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Type_Weekly extends Tx_CzSimpleCal_Recurrance_Type_Base {
	
	/**
	 * the main method building the recurrance
	 * 
	 * @return void
	 */
	protected function doBuild() {
		
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		$interval = $this->event->getRecurranceSubtype();
		if($interval === 'weekly') {
			$step = '+1 week';
		} elseif($interval === 'oddeven') {
			$this->buildOddEven($start, $end, $until);
			return;
		} elseif($interval === '2week') {
			$step = '+2 week';
		} elseif($interval === '3week') {
			$step = '+3 week';
		} elseif($interval === '4week') {
			$step = '+4 week';
		} else {
			$step = '+1 week';
		}
		
		while($until >= $start) {
			
			$this->timeline->add(array(
				'start' => $start->getTimestamp(),
				'end'   => $end->getTimestamp()
			));
			
			$start->modify($step);
			$end->modify($step);
			
		}
	}
	
	/**
	 * special method to build events taking place on odd or even weeks
	 * 
	 * @param Tx_CzSimpleCal_Utility_DateTime $start
	 * @param Tx_CzSimpleCal_Utility_DateTime $end
	 * @param Tx_CzSimpleCal_Utility_DateTime $until
	 */
	protected function buildOddEven($start, $end, $until) {
		
		$week = $start->format('W') % 2;
		while($until >= $start) {
			
			$this->timeline->add(array(
				'start' => $start->getTimestamp(),
				'end'   => $end->getTimestamp()
			));
			
			$start->modify('+2 week');
			$end->modify('+2 week');
			
			// take care of year switches
			if($start->format('W') % 2 !== $week) {
				$start->modify('-1 week');
				$end->modify('-1 week');
			}
		}
	}
	
	/**
	 * get the configured subtypes of this recurrance
	 * 
	 * @return array
	 */
	public static function getSubtypes() {
		return self::addLL(array('weekly', 'oddeven', '2week', '3week', '4week'));
	}
	
}