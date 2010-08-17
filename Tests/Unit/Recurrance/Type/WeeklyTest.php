<?php 
//require_once 'PHPUnit/Framework.php';
//require_once dirname(__FILE__).'/../../../Classes/Domain/Interface/HasTimespan.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Base.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Weekly.php';
//require_once dirname(__FILE__).'/../../../Classes/Utility/DateTime.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Timeline/Base.php';
require_once dirname(__FILE__).'/../../../Mocks/IsRecurringMock.php';


/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Daily
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCalTests_Recurrance_Type_WeeklyTest extends Tx_Extbase_BaseTestCase {
	
	protected function buildRecurrance($event, $timeline = null) {
		if(is_null($timeline)) {
			$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		}
		$typeWeekly = new Tx_CzSimpleCal_Recurrance_Type_Weekly();
		
		return $typeWeekly->build($event, $timeline);
	}
	
	
	public function testRecurranceUntil() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'           => '2009-02-13 23:31:30GMT',
			'end'             => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-02-20 23:59:59GMT'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-02-20 23:31:30GMT'),
			'end'   => strtotime('2009-02-20 23:31:30GMT')
		), $return->next(), 'times are preserved');
	}
	
	public function testIfOnlyStartIsSignificant() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-02-25 16:00:00GMT'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two event returned.');
	}
	
	public function testRecurranceWeeklyIntervalWeekly() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-02-25 16:00:00GMT',
			'recurrance_weekly_interval' => 'weekly'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-02-20 23:31:30GMT'),
			'end'   => strtotime('2009-02-20 23:31:30GMT')
		), $return->next(), 'times are preserved');
	}
	
	public function testRecurranceWeeklyInterval2Week() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-03-04 16:00:00GMT',
			'recurrance_weekly_interval' => '2week'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-02-27 23:31:30GMT'),
			'end'   => strtotime('2009-02-27 23:31:30GMT')
		), $return->next(), 'correct interval used');
	}
	
	public function testRecurranceWeeklyIntervalOddEven() {
		
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-03-04 16:00:00GMT',
			'recurrance_weekly_interval' => 'oddeven'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-02-27 23:31:30GMT'),
			'end'   => strtotime('2009-02-27 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		
		
		
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-12-28 23:31:30GMT',
			'end'              => '2009-12-28 23:31:30GMT',
			'recurrance_until' => '2010-01-07 16:00:00GMT',
			'recurrance_weekly_interval' => 'oddeven'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'on year switch: exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-12-28 23:31:30GMT'),
			'end'   => strtotime('2009-12-28 23:31:30GMT')
		), $return->current(), 'on year switch: first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2010-01-04 23:31:30GMT'),
			'end'   => strtotime('2010-01-04 23:31:30GMT')
		), $return->next(), 'on year switch: correct interval used');
	}
	
	public function testRecurranceWeeklyInterval3Week() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-03-11 16:00:00GMT',
			'recurrance_weekly_interval' => '3week'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-06 23:31:30GMT'),
			'end'   => strtotime('2009-03-06 23:31:30GMT')
		), $return->next(), 'correct interval used');
	}
	
	public function testRecurranceWeeklyInterval4Week() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-03-18 16:00:00GMT',
			'recurrance_weekly_interval' => '4week'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-13 23:31:30GMT'),
			'end'   => strtotime('2009-03-13 23:31:30GMT')
		), $return->next(), 'correct interval used');
	}
	
	
}
	