<?php 

/**
 * monthly recurrance
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Type_Monthly extends Tx_CzSimpleCal_Recurrance_Type_Base {
	
	/**
	 * the main method building the recurrance
	 * 
	 * @return void
	 */
	protected function doBuild() {
		
		$type = $this->event->getRecurranceSubtype();
		
		if(($type === 'bydayofmonth')) {
			$this->buildByDay();
			return;
		} elseif(strpos($type, 'weekdayofmonth') !== false) {
			if($type === 'firstweekdayofmonth') {
				$param = 1;
			} elseif($type === 'lastweekdayofmonth') {
				$param = -1;
			} elseif($type === 'secondweekdayofmonth') {
				$param = 2;
			} elseif($type === 'thirdweekdayofmonth') {
				$param = 3;
			} elseif($type === 'penultimateweekdayofmonth') {
				$param = -2;
			}
			
			$this->buildByWeekday($param);
			return;
		}
		
		$start = clone $this->event->getDateTimeObjectStart();
		$day = $start->format('d');
		$daysInMonth = $start->modify('last day of this month');
		
		if($day <= 7) {
			$param = 1;
		} elseif($day <= 14) {
			$param = 2;
		} elseif($daysInMonth - $day < 7) {
			$param = -1;
		} elseif($daysInMonth - $day < 14) {
			$param = -2;
		} else {
			$param = 3;
		}
		$this->buildByWeekday($param);
	}

	protected function buildByWeekday($pos) {
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		$diff = $end->getTimestamp() - $start->getTimestamp();
		
		while($until >= $start) {
			
			$this->timeline->add(array(
				'start' => $start->getTimestamp(),
				'end'   => $end->getTimestamp()
			));
			
			$this->advanceOneMonthByWeekday($start, $pos);
			$end = clone $start;
			$end->modify(sprintf('+ %d seconds', $diff));
		}
	}
	
	protected function advanceOneMonthByWeekday($date, $pos) {
		if($pos > 0) {
			$date->modify('first day of next month|'.$date->format('l H:i:s'));
			if($pos > 1) {
				$date->modify(sprintf('+%d weeks', $pos-1));
			}
		} else {
			$date->modify(sprintf('last day of next month|next %s| %d weeks', $date->format('l H:i:s'), $pos));
		}
	}
	
	protected function buildByDay() {
		$start = clone $this->event->getDateTimeObjectStart();
		$end = clone $this->event->getDateTimeObjectEnd();
		$until = $this->event->getDateTimeObjectRecurranceUntil();
		
		if($start->format('j') > 28 || $end->format('j') > 28 ) {
			throw new Tx_CzSimpleCal_Recurrance_BuildException('The day of month of the start or the end was larger than 28. Abortion as this might lead to unexpected results.');
		}
		
		while($until >= $start) {
			
			$this->timeline->add(array(
				'start' => $start->getTimestamp(),
				'end'   => $end->getTimestamp()
			));
			
			$start->modify('+1 month');
			$end->modify('+1 month');
		}
	}
	
	/**
	 * get the configured subtypes of this recurrance
	 * 
	 * @return array
	 */
	public static function getSubtypes() {
		return self::addLL(array('auto', 'bydayofmonth', 'firstweekdayofmonth', 'secondweekdayofmonth', 'thirdweekdayofmonth', 'lastweekdayofmonth', 'penultimateweekdayofmonth'));
	}
	
}