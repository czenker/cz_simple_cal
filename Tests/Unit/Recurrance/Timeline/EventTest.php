<?php 
 
/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Timeline_Event
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTimlineEventTest extends Tx_Extbase_BaseTestCase {
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Timeline_Event
	 */
	protected $timeline = null;
	
	public function setUp() {
		$this->timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Event();
	}
	
	public function testInheritance() {
		self::assertTrue($this->timeline instanceof Tx_CzSimpleCal_Recurrance_Timeline_Base, 'inherits from Tx_CzSimpleCal_Recurrance_Timeline_Base');
	}
	
	public function testAddingOfEvent() {
		$event = new Tx_CzSimpleCal_Domain_Model_Event();
		
		$this->timeline->setEvent($event);
		
		$this->timeline->add(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end' => strtotime('2009-02-13 23:31:31GMT')
		));
		
		$current = $this->timeline->current();
		
		self::assertArrayHasKey('event', $current, 'data gets key "event"');
		self::assertArrayHasKey('pid', $current, 'data gets key "pid"');
	}
	
}