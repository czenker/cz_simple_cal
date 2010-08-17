<?php 

require_once dirname(__FILE__).'/../../../Mocks/IsRecurringMock.php';

/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Daily
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCalTests_Recurrance_Type_MonthlyTest extends Tx_Extbase_BaseTestCase {
	
	protected function buildRecurrance($event, $timeline = null) {
		if(is_null($timeline)) {
			$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		}
		$typeWeekly = new Tx_CzSimpleCal_Recurrance_Type_Monthly();
		
		return $typeWeekly->build($event, $timeline);
	}
	
	public function testRecurranceSubtypeByDayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-03-18 16:00:00GMT',
			'recurrance_subtype' => 'bydayofmonth'
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
	
	/**
	 * @expectedException Tx_CzSimpleCal_Recurrance_BuildException
	 */
	public function testRecurranceSubtypeByDayOfMonthOnA31thThrowsException() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-01-31 23:31:30GMT',
			'end'              => '2009-01-31 23:31:30GMT',
			'recurrance_until' => '2009-04-15 16:00:00GMT',
			'recurrance_subtype' => 'bydayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
	}
	
	public function testRecurranceSubtypeByDayOfMonthForEventsOverMonthsBorder() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-03-02 23:31:30GMT',
			'recurrance_until' => '2009-03-18 16:00:00GMT',
			'recurrance_subtype' => 'bydayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-03-02 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-13 23:31:30GMT'),
			'end'   => strtotime('2009-04-02 23:31:30GMT')
		), $return->next(), 'correct interval used');
	}
	
	
	
	
	
	public function testRecurranceSubtypeFirstWeekdayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-05-18 16:00:00GMT',
			'recurrance_subtype' => 'firstweekdayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(4, count($return->toArray()), 'exactly four events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-06 23:31:30GMT'),
			'end'   => strtotime('2009-03-06 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-05-01 23:31:30GMT'),
			'end'   => strtotime('2009-05-01 23:31:30GMT')
		), $return->next(), 'no advance to next week if week starts with the required weekday');
	}
	
	public function testRecurranceSubtypeSecondWeekdayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-05-31 16:00:00GMT',
			'recurrance_subtype' => 'secondweekdayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(4, count($return->toArray()), 'exactly four events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-13 23:31:30GMT'),
			'end'   => strtotime('2009-03-13 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-05-08 23:31:30GMT'),
			'end'   => strtotime('2009-05-08 23:31:30GMT')
		), $return->next(), 'no advance to next week if week starts with the required weekday');
	}
	
	public function testRecurranceSubtypeThirdWeekdayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-05-31 16:00:00GMT',
			'recurrance_subtype' => 'thirdweekdayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(4, count($return->toArray()), 'exactly four events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-20 23:31:30GMT'),
			'end'   => strtotime('2009-03-20 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-05-15 23:31:30GMT'),
			'end'   => strtotime('2009-05-15 23:31:30GMT')
		), $return->next(), 'no advance to next week if week starts with the required weekday');
	}
	
	public function testRecurranceSubtypeLastWeekdayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-08-01 16:00:00GMT',
			'recurrance_subtype' => 'lastweekdayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(6, count($return->toArray()), 'exactly six events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-27 23:31:30GMT'),
			'end'   => strtotime('2009-03-27 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		$return->next();
		$return->next();
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-07-31 23:31:30GMT'),
			'end'   => strtotime('2009-07-31 23:31:30GMT')
		), $return->next(), 'no advance to next week if week ends with the required weekday');
	}
	
	public function testRecurranceSubtypePenultimateWeekdayOfMonth() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-08-01 16:00:00GMT',
			'recurrance_subtype' => 'penultimateweekdayofmonth'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(6, count($return->toArray()), 'exactly six events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		self::assertEquals(array(
			'start' => strtotime('2009-03-20 23:31:30GMT'),
			'end'   => strtotime('2009-03-20 23:31:30GMT')
		), $return->next(), 'correct interval used');
		
		$return->next();
		$return->next();
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-07-24 23:31:30GMT'),
			'end'   => strtotime('2009-07-24 23:31:30GMT')
		), $return->next(), 'no advance to next week if week ends with the required weekday');
	}
	
	public function testRecurranceSubtypeAuto() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'            => '2009-02-13 23:31:30GMT',
			'end'              => '2009-02-13 23:31:30GMT',
			'recurrance_until' => '2009-04-12 16:00:00GMT',
			'recurrance_subtype' => 'auto'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(3, count($return->toArray()), 'exactly three events returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'first event equals the input settings');
		
		$return->next();
		
		self::assertEquals(array(
			'start' => strtotime('2009-04-10 23:31:30GMT'),
			'end'   => strtotime('2009-04-10 23:31:30GMT')
		), $return->next(), 'correctly interpreted as second friday in month');
	}
	
}	