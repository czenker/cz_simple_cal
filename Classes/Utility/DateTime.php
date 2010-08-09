<?php 

/**
 * an extension of the DateTime object
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_DateTime extends DateTime {

	public function __construct($dateTime = null, $timezone = null) {
		
		$time = Tx_CzSimpleCal_Utility_StrToTime::doSubstitutions($dateTime);
		
		$time = t3lib_div::trimExplode('|', $time, true);
		
		$thisTime = strftime(array_shift($time));
		
		if(is_null($timezone)) {
			parent::__construct($thisTime);
		} else {
			parent::__construct($thisTime, $timezone);
		}
	}
//	
//	/**
//	 * apply modifications on the date
//	 * @param array $dateTime
//	 */
//	protected function doModify($time) {
//		$timezone = date_default_timezone_get();
//		date_default_timezone_set('GMT');
//		$now = $this->getTimestamp();
//		
//		
//		foreach($time as $part) {
//			$now = strtotime(strftime($part, $now), $now);
//		}
//		$this->setTimestamp($now);
//		
//		date_default_timezone_set($timezone);
//	}
//	
//	public function modify($dateTime, $parse = true) {
//		$time = Tx_CzSimpleCal_Utility_StrToTime::doSubstitutions($dateTime);
//		$time = t3lib_div::trimExplode('|', $time, true);
//		$this->doModify($time);
//	}
//	
	public function getTimestamp() {
		return $this->format('U');
	}
	
}