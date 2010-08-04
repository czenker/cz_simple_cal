<?php 

/**
 * an extension of the DateTime object
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_DateTime extends DateTime {

	public function __construct($dateTime = null) {
		parent::__construct(date('c', Tx_CzSimpleCal_Utility_StrToTime::strtotime($dateTime)));
	}
	
	public function modify($dateTime) {
		$modified = Tx_CzSimpleCal_Utility_StrToTime::strtotime($dateTime, $this->getTimestamp());
		parent::setDate(date('Y', $modified), date('m', $modified), date('d', $modified));
		parent::setTime(date('H', $modified), date('i', $modified), date('s', $modified));
	}
	
	public function getTimestamp() {
		return $this->format('U');
	}

}