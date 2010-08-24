<?php 

/**
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_EventConfig {

	public function getRecurranceSubtype($config) {
		$type = trim($config['row']['recurrance_type']);
		
		if(empty($type)) {
			return;
		}
		
		$className = 'Tx_CzSimpleCal_Recurrance_Type_'.t3lib_div::underscoredToUpperCamelCase($type);
		$callback = array($className, 'getSubtypes');
		
		if(!class_exists($className) || !is_callable($callback)) {
			return;
		}
		
		$config['items'] = call_user_func($callback);
	}
	
}