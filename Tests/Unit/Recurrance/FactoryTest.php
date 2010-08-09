<?php 

require_once dirname(__FILE__).'/../../Mocks/class.MockHasTimespanClass.php';

/**
 * testing the features of Tx_CzSimpleCal_Recurrance_FactoryTest
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Recurrance_FactoryTest extends Tx_Extbase_BaseTestCase {
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Factory_Mock
	 */
	protected $factory = null;
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Timeline_Event
	 */
	protected $events = null;
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Timeline_Exception
	 */
	protected $exceptions = null;
	
	public function setUp() {
		$this->factory = new Tx_CzSimpleCal_Recurrance_Factory_Mock();
		$this->events = new Tx_CzSimpleCal_Recurrance_Timeline_Event_Mock();
		$this->events->setEvent(new Tx_CzSimpleCal_Domain_Model_Event());
		$this->exceptions = new Tx_CzSimpleCal_Recurrance_Timeline_Exception();
	}
	
	/**
	 * what if no exceptions are given at all
	 * 
	 * @dataProvider provideDataForEmptyException
	 */
	public function testEmptyException($eventData) {
		
		$this->setEventData($eventData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals($eventData, $events->getData(), 'data remains unchanged');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForEmptyException() {
		return array(
			'1 event' => array($this->generateFakeData(1)),
			'3 events' => array($this->generateFakeData(3)),
		);
	}
	
	/**
	 * what if exceptions are given, but they don't match any event
	 * 
	 * event     : ########
	 * exception :            ########
	 * 
	 * @dataProvider provideDataForNonMatchingException
	 */
	public function testNonMatchingException($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals($eventData, $events->getData(), 'data remains unchanged');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForNonMatchingException() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 14:00:00GMT', '+1 hour')
			),
			'3 events' => array(
				$this->generateFakeData(3, '2009-01-01 00:00:00GMT', '+12 hours', '+1 day'),
				$this->generateFakeData(3, '2009-01-01 14:00:00GMT', '+1 hour', '+1 day')
			),
			'zero length exceptions (3 events)' => array(
				$this->generateFakeData(3, '2009-01-01 00:00:00GMT', '+12 hours', '+1 day'),
				$this->generateFakeData(3, '2009-01-01 14:00:00GMT', 'now', '+1 day')
			),
			'zero length events (3 events)' => array(
				$this->generateFakeData(3, '2009-01-01 00:00:00GMT', 'now', '+1 day'),
				$this->generateFakeData(3, '2009-01-01 14:00:00GMT', '+1 hour', '+1 day')
			),
			
			
		);
	}
	
	/**
	 * what if an exception starts before an event ends but exception finishes afterwards
	 * 
	 * event     : ########
	 * exception :     ########
	 * 
	 * @dataProvider provideDataForExceptionBeforeEventEnd
	 */
	public function testExceptionBeforeEventEnd($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionBeforeEventEnd() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 06:00:00GMT', '+12 hours')
			),
		);
	}
	
	/**
	 * what if an exceptions has started when the event starts, but stops earlier than the event
	 * 
	 * event     :     ########
	 * exception : ########
	 * 
	 * @dataProvider provideDataForExceptionBeforeEventStart
	 */
	public function testExceptionBeforeEventStart($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionBeforeEventStart() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 06:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours')
			)
		);
	}
	
	/**
	 * what if an exception covers a whole event
	 * 
	 * event     :     ########
	 * exception : ################
	 * 
	 * @dataProvider provideDataForExceptionOverlapsEventCompletely
	 */
	public function testExceptionOverlapsEventCompletely($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionOverlapsEventCompletely() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 06:00:00GMT', '+3 hours'),
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours')
			),
			'zero length event' => array(
				$this->generateFakeData(1, '2009-01-01 06:00:00GMT', 'now'),
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours')
			)
			
		);
	}
	
	/**
	 * what if an exception applies just when the event runs
	 * 
	 * event     : ################
	 * exception :     ########
	 * 
	 * @dataProvider provideDataForExceptionWhileEvent
	 */
	public function testExceptionWhileEvent($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionWhileEvent() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 06:00:00GMT', '+3 hours')
			)
		);
	}
	
	/**
	 * what if an exception ends excactly when an event starts
	 * 
	 * event     :     ########
	 * exception : ####
	 * 
	 * @dataProvider provideDataForExceptionEndsWhenEventStarts
	 */
	public function testExceptionEndsWhenEventStarts($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals($eventData, $events->getData(), 'data remains unchanged');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionEndsWhenEventStarts() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 12:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours')
			),
			'zero length event' => array(
				$this->generateFakeData(1, '2009-01-01 12:00:00GMT', 'now'),
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours')
			),
		);
	}
	
	/**
	 * what if an exception starts excactly when an event ends
	 * 
	 * event     : ####
	 * exception :     ########
	 * 
	 * @dataProvider provideDataForExceptionStartsWhenEventEnds
	 */
	public function testExceptionStartsWhenEventEnds($eventData, $exceptionData) {
			
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals($eventData, $events->getData(), 'data remains unchanged');
		
		$returnTimespan = current($events);
	}
	
	public function provideDataForExceptionStartsWhenEventEnds() {
		return array(
			'1 event' => array(
				$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+12 hours'),
				$this->generateFakeData(1, '2009-01-01 12:00:00GMT', '+6 hours')
			),
		);
	}
	
	/**
	 * what if an exception starts excactly when an atomic event starts
	 * 
	 * event     : |
	 * exception : ########
	 * 
	 */
	public function testExceptionStartsWhenAtomicEventStarts() {
		
		$eventData = $this->generateFakeData(1, '2009-01-01 00:00:00GMT', 'now');
		$exceptionData = $this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+6 hours');
		
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
	}
	
	
	
	
/*
 * tests for multiple events
 */	
	
	/**
	 * multiple events are affected by one exception
	 * 
	 * exception :   ######
	 * 
	 * events    : ####
	 *               ####
	 *                 ####
	 *                   #### 
	 */
	public function testExceptionAffectsMultipleEvents() {
		$eventData = $this->generateFakeData(24, '2009-01-01 23:00:00GMT', '+2 hours', '+1 hour');
		$exceptionData = $this->generateFakeData(1, '2009-01-02 00:00:00GMT', '+1 day');
		
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
	}
	
	/**
	 * multiple events are affected by one exception
	 * 
	 * event      :   ######
	 * 
	 * exceptions : ####
	 *                ####
	 *                  ####
	 *                    #### 
	 */
	public function testMultipleExceptionsAffectEvent() {
		$exceptionData = $this->generateFakeData(24, '2009-01-01 23:00:00GMT', '+2 hours', '+1 hour');
		$eventData = $this->generateFakeData(1, '2009-01-02 00:00:00GMT', '+1 day');
		
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
	}
	
	
	/**
	 * exceptions : ######
	 *                  ######
	 * events     :   ##########
	 *                      ######
	 */
	public function testComplexExamplePattern1() {
		
		$exceptionData = array_merge(
			$this->generateFakeData(1, '2009-01-01 00:00:00GMT', '+3 hours'),
			$this->generateFakeData(1, '2009-01-01 02:00:00GMT', '+3 hours')
		);
		$eventData = array_merge(
			$this->generateFakeData(1, '2009-01-01 01:00:00GMT', '+5 hours'),
			$this->generateFakeData(1, '2009-01-01 03:00:00GMT', '+4 hours')
		);
		
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(0, $events->count(), 'all events are unset');
	}
	
	/**
	 * 
	 * this pattern is repeated 30 times:
	 * 
	 *              |           |           |           |           |
	 * exceptions : ############            ############
	 * events     : ####                                        ####
	 *                            ########
	 *                              ####
	 *                                ######
	 *                                  ########
	 */
	public function testComplexExamplePattern2() {
		
		$exceptionData = $this->generateFakeData(60, '2009-01-01 00:00:00GMT', '+6 hours', '+12 hours');
		$eventData = array_merge(
			$this->generateFakeData(30, '2008-12-31 22:00:00GMT', '+4 hours', '+1 day'),
			$this->generateFakeData(30, '2009-01-01 07:00:00GMT', '+4 hours', '+1 day'),
			$this->generateFakeData(30, '2009-01-01 08:00:00GMT', '+2 hours', '+1 day'),
			$this->generateFakeData(30, '2009-01-01 09:00:00GMT', '+3 hours', '+1 day'),
			$this->generateFakeData(30, '2009-01-01 10:00:00GMT', '+4 hours', '+1 day')
		);
		
		$this->setEventData($eventData);
		$this->setExceptionData($exceptionData);
		
		$events = $this->factory->dropExceptionalEvents($this->events, $this->exceptions);
		
		self::assertEquals(90, $events->count(), 'correct count of events');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	protected function generateFakeData($number = 1, $startAt = '2009-01-01 00:00:00GMT', $length = '+12 hours', $gap = '+1 day') {
		$ret = array();
		
		$now = strtotime($startAt);
		
		while($number-- > 0) {
			$ret[] = array(
				'start' => $now,
				'end'   => strtotime($length, $now)
			);
			$now = strtotime($gap, $now);
		}
		
		return $ret;
	}
	
	protected function setEventData($data) {
		foreach($data as $timespan) {
			$this->events->add($timespan);
		}
	}
	
	protected function setExceptionData($data) {
		foreach($data as $timespan) {
			$this->exceptions->add($timespan);
		}
	}
	
	
	
	
}

require_once(t3lib_extMgm::extPath('cz_simple_cal').'Classes/Recurrance/Factory.php');

class Tx_CzSimpleCal_Recurrance_Factory_Mock extends Tx_CzSimpleCal_Recurrance_Factory {
	public function dropExceptionalEvents($events, $exceptions) {
		return parent::dropExceptionalEvents($events, $exceptions);
	}
}

require_once(t3lib_extMgm::extPath('cz_simple_cal').'Classes/Recurrance/Timeline/Base.php');
require_once(t3lib_extMgm::extPath('cz_simple_cal').'Classes/Recurrance/Timeline/Event.php');

class Tx_CzSimpleCal_Recurrance_Timeline_Event_Mock extends Tx_CzSimpleCal_Recurrance_Timeline_Event {
	public function getData() {
		return $this->count() > 0 ? 
			array_combine(
				array_flip(array_keys(array_fill(0, $this->count(), 'foo'))), //substitude data keys with numeric keys
				$this->data
			) : 
			array()
		;
	}
}
	