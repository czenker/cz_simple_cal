<?php 

require_once dirname(__FILE__).'/../../../Mocks/IsRecurringMock.php';

/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Daily
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCalTests_Recurrance_Type_DailyTest extends Tx_Extbase_BaseTestCase {
	
	protected function buildRecurrance($event, $timeline = null) {
		if(is_null($timeline)) {
			$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		}
		$typeDaily = new Tx_CzSimpleCal_Recurrance_Type_Daily();
		
		return $typeDaily->build($event, $timeline);
	}
	
	public function testRecurranceUntil() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'           => '2009-02-13 23:31:30GMT',
			'end'             => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-02-14 23:59:59GMT'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'this event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-02-14 23:31:30GMT'),
			'end'   => strtotime('2009-02-14 23:31:30GMT')
		), $return->next(), 'times are preserved');
	}
	
	public function testIfOnlyStartIsSignificant() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-15 16:00:00GMT',
			'recurrance_until' => '2009-02-14 23:59:59GMT'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two event returned.');
	}
	
}
	