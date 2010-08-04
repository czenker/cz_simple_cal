<?php 

/**
 * A class holding configuration from the extensions configuration
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_Config {
	
	protected static $data = null;
	
	public static function get($name) {
		if(is_null(self::$data)) {
			self::$data = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cz_simple_cal']);
		}
		
		if(!self::exists($name)) {
			throw new InvalidArgumentException(sprintf('The value "%s" was not set. Did you update the Extensions settings?', $name));
		}
		
		return self::$data[$name];
	}
	
	protected static function exists($name) {
		return array_key_exists($name, self::$data);
	}
	
}