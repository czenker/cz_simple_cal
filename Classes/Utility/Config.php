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
	
	protected function set($name, $value = null) {
		if(is_string($name)) {
			$this->data[$name] = $value;
		} elseif(is_array($name)) {
			$this->data = array_merge(
				is_null($this->data) ? array() : $this->data,
				$name
			);
		} else {
			throw new InvalidArgumentException('The value "name" must be a string or array.');
		}
	}
	
}