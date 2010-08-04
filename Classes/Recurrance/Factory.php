<?php 

/**
 * manages the build of all recurrant events
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Factory {
	
	static function buildRecurranceForEvent($event) {
		if(!$event instanceof Tx_CzSimpleCal_Domain_Model_Event) {
			throw new InvalidArgumentException(sprintf('$event must be of class Tx_CzSimpleCal_Domain_Model_Event in %s::%s', get_class($this), __METHOD__));
		}
		
		$type = $event->getRecurranceType();
		if(empty($type)) {
			throw new RuntimeException('The recurrance_type should not be empty.');
		}
		
		$className = 'Tx_CzSimpleCal_Recurrance_'.t3lib_div::underscoredToUpperCamelCase($type);
		
		if(!class_exists($className)) {
			throw new BadMethodCallException(sprintf('The class %s does not exist for creating recurring events.', $className));
		}
		
		$class = t3lib_div::makeInstance($className);
		
		if(!$class instanceof Tx_CzSimpleCal_Recurrance_Base) {
			throw new BadMethodCallException(sprintf('The class %s does not implement the Tx_CzSimpleCal_Recurrance_Base.', get_class($class)));
		}
		
		return $class->build($event);
	}
	
}