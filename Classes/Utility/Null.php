<?php 

/**
 * A class doing nothing
 * 
 * (used as backend user to clear cache when an event was created/updated
 * in the EventAdministration controller without getting a log message)
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_Null {
	public function __call($methodName, $arguments) {
		return null;
	}
	
	public function __get($argument) {
		return null;
	}
}