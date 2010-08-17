<?php 

/**
 * manages the build of all recurrant events
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Factory {
	
	/**
	 * the event to build the recurrance for
	 * 
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $event = null;
	
	/**
	 * build the recurrance for an event
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_BaseEvent $event
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function buildRecurranceForEvent($event) {
		if(!$event instanceof Tx_CzSimpleCal_Domain_Model_BaseEvent) {
			// no type hinting to make it more reusable
			throw new InvalidArgumentException(sprintf('$event must be of class Tx_CzSimpleCal_Domain_Model_BaseEvent in %s::%s', get_class($this), __METHOD__));
		}
		
		$this->event = $event;
		
		/**
		 * a class holding all possible events ordered by their starttime ascending
		 * 
		 * @var Tx_CzSimpleCal_Recurrance_Timeline_Event
		 */
		$events = $this->buildEventTimeline();
		
		/**
		 * a class holding all exceptions
		 */
		$exceptions = $this->buildExceptionTimeline();
		
		return $this->dropExceptionalEvents($events, $exceptions);
	}
	
	/**
	 * build the recurrance for all events paying no attention to exceptions 
	 * 
	 * @return Tx_CzSimpleCal_Recurrance_Timeline_Event
	 */
	protected function buildEventTimeline() {
		
		$type = $this->event->getRecurranceType();
		if(empty($type)) {
			throw new RuntimeException('The recurrance_type should not be empty.');
		}
		
		$className = 'Tx_CzSimpleCal_Recurrance_Type_'.t3lib_div::underscoredToUpperCamelCase($type);
		
		if(!class_exists($className)) {
			throw new BadMethodCallException(sprintf('The class %s does not exist for creating recurring events.', $className));
		}
		
		$class = t3lib_div::makeInstance($className);
		
		if(!$class instanceof Tx_CzSimpleCal_Recurrance_Type_Base) {
			throw new BadMethodCallException(sprintf('The class %s does not implement the Tx_CzSimpleCal_Recurrance_Type_Base.', get_class($class)));
		}
		
		$eventTimeline = new Tx_CzSimpleCal_Recurrance_Timeline_Event();
		$eventTimeline->setEvent($this->event);
		
		return $class->build($this->event, $eventTimeline);
	}
	
	/**
	 * build the exception timeline
	 * 
	 * @return Tx_CzSimpleCal_Recurrance_Timeline_Exception
	 */
	protected function buildExceptionTimeline() {
		$exceptionTimeline = new Tx_CzSimpleCal_Recurrance_Timeline_Exception();
		
		foreach($this->event->getExceptions() as $exception) {
			
			$type = $exception->getRecurranceType();
			if(empty($type)) {
				throw new RuntimeException('The recurrance_type should not be empty.');
			}
			
			$className = 'Tx_CzSimpleCal_Recurrance_Type_'.t3lib_div::underscoredToUpperCamelCase($type);
			
			if(!class_exists($className)) {
				throw new BadMethodCallException(sprintf('The class %s does not exist for creating recurring events.', $className));
			}
			
			$class = t3lib_div::makeInstance($className);
			
			if(!$class instanceof Tx_CzSimpleCal_Recurrance_Type_Base) {
				throw new BadMethodCallException(sprintf('The class %s does not implement Tx_CzSimpleCal_Recurrance_Type_Base.', get_class($class)));
			}
			
			$exceptionTimeline = $class->build($exception, $exceptionTimeline);
		}
		return $exceptionTimeline;
	}
	
	/**
	 * drop all events that are blocked by an exception
	 * 
	 * some words on how it works:
	 * 
	 * Basically the idea here is to check every event if it overlaps an exception.
	 * 
	 * To make this algorithm a bit more efficant, these prerequisits are met:
	 *  - the events are ordered by their start-date (no duplicate start dates),
	 *  - the exceptions by their start-date (no duplicate start dates)
	 * 
	 * So if we find, that the end-date of an exception is before the current start-date
	 * it is before the start-date of ALL remaining events and we'll just drop it.
	 *  
	 * 
	 * @param Tx_CzSimpleCal_Recurrance_Timeline_Events $events
	 * @param Tx_CzSimpleCal_Recurrance_Timeline_Exception $exceptions
	 * @return Tx_CzSimpleCal_Recurrance_Timeline_Events
	 */
	protected function dropExceptionalEvents($events, $exceptions) {
		
		foreach($events as $eventKey=>$event) {
			
			if(!$exceptions->hasData()) {
				break;
			}
			
//			$exceptions->rewind();
			foreach($exceptions as $exceptionKey=>$exception) {
				
				if($exception['end'] <= $eventKey /*eventKey = $event['start']*/) {
					//if: end of exception is before start of event -> delete it as it won't affect any more of the events
					$exceptions->unsetCurrent();
				} elseif($event['end'] < $exceptionKey /*exceptionKey = $exception['start']*/ ||
						($event['end'] == $exceptionKey && $event['start'] != $event['end'] )) {
					//if: end of event is before start of exception or 
					//    end of event matches start of exception and the event is not zero length
					//    -> none of the following exception will affect this event
					break;
				} else {
					// else: match -> delete this event
					$events->unsetCurrent();
					break;
				}
			}
		}
		return $events;
		
	}
	
}