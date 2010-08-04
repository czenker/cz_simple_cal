<?php 
//require_once 'PHPUnit/Framework.php';
//require_once dirname(__FILE__).'/../../../Classes/Domain/Interface/HasTimespan.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Base.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Weekly.php';
//require_once dirname(__FILE__).'/../../../Classes/Utility/DateTime.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Timeline/Base.php';
require_once dirname(__FILE__).'/../../../Mocks/class.MockHasTimespanClass.php';


/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Daily
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTypeWeeklyTest extends Tx_Extbase_BaseTestCase {
	
	public function testRecurranceUntil() {
		$event = new MockHasTimespanClass(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT')
		);
		
		$event->set('dateTimeObjectRecurranceUntil', new Tx_CzSimpleCal_Utility_DateTime('2009-02-20 23:59:59GMT'));
		
		$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		
		$typeWeekly = new Tx_CzSimpleCal_Recurrance_Type_Weekly();
		
		$return = $typeWeekly->build($event, $timeline);
		
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
		$event = new MockHasTimespanClass(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-25 16:00:00GMT')
		);
		
		$event->set('dateTimeObjectRecurranceUntil', new Tx_CzSimpleCal_Utility_DateTime('2009-02-20 23:59:59GMT'));
		
		$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		
		$typeWeekly = new Tx_CzSimpleCal_Recurrance_Type_Weekly();
		
		$return = $typeWeekly->build($event, $timeline);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two event returned.');
	}
	
	
}
	