<?php 

/**
 * a collection of static methods to manipulate dates
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 * @deprecated
 */
class Tx_CzSimpleCal_Utility_Date {
//	
//	/**
//	 * takes dates and times as they come from the TYPO3 database and returns a timestamp
//	 * 
//	 * @param integer $date     a unix timestamp from midnight of the day
//	 * @param integer $time     seconds from midnight
//	 * @param string  $timezone the timezone used when creating the event
//	 * @param boolean $start    if this is a start event (needed for all-day events)  
//	 * @return integer
//	 */
//	static public function getDateTimeFromDateAndTime($date, $time, $timezone = null, $start = true) {
//		
//		if($date < 0) {
//			if($start) {
//				throw new InvalidArgumentException('A start date needs to be set.');
//			} else {
//				//if: date is not set and this is an enddate - this is an oneday-allday or a date with default length
//				return false;
//			}
//		}
//		
//		if($time < 0) {
//			//if: this is an allday-event
//			return $start ? 
//				strtotime(date('Y-m-d', $date).' 00:00:00'.$timezone) : 
//				strtotime(date('Y-m-d', $date).' 23:59:59'.$timezone)
//			;
//		} else {
//			return strtotime(date('Y-m-d', $date).' '.date('H:i:s', $time).$timezone); 
//		}
//	}
//	
//	/**
//	 * get the start and stop of an event as they come from the database
//	 * 
//	 * @param integer $start_date   a unix timestamp from midnight of the day
//	 * @param integer $start_time   seconds from midnight
//	 * @param integer $end_date     a unix timestamp from midnight of the day
//	 * @param integer $end_time     seconds from midnight
//	 * @param string  $timezone     the timezone used when creating the event
//	 * @return array[start, end]
//	 */
//	static public function getStartAndEndFromDatesAndTimes($start_date, $start_time = -1, $end_date = -1, $end_time = -1, $timezone = null) {
//		
//		$start = self::getDateTimeFromDateAndTime($start_date, $start_time, $timezone);
//		$end = self::getDateTimeFromDateAndTime($end_date, $end_time, $timezone, false);
//		
//		if($end === false) {
//			if($start_time < 0) {
//				// if: this is an allday event - end time is end of the day
//				$end = self::getDateTimeFromDateAndTime($start_date, $end_time, false);
//			} else {
//				// else: this is an event with no stop time
//				$end = $start;
//			}
//		}
//		
//		return array(
//			'start' => $start,
//			'end' => $end
//		);
//	}
//	
//	/**
//	 * get the timestamp of the end of a day
//	 * 
//	 * @param integer $day some time of the day
//	 * @return integer
//	 */
//	static public function getEndOfDay($day) {
//		return strtotime(date('Y-m-d', $day).' 23:59:59');
//	}
//	
//	
//	static public function addWeeks($date, $weeks) {
//		return strtotime(sprintf('+%d week',$weeks), $date);
//	}
}