<?php 

/**
 * an extension of the DateTime object
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_DateTime extends DateTime {
	
	
	public function getTimestamp() {
		return $this->format('U');
	}		
	
}