<?php 
t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
/**
 * it is not possible to create a class dynamically, if its name does not start with "tx_" or "user_".
 * "Tx_" has the incorrect case therefore 
 */
class tx_czsimplecal_dynFlexform {

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