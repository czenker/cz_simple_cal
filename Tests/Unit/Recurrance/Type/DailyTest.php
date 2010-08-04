<?php 
//require_once 'PHPUnit/Framework.php';
//require_once t3lib_extmgm::extPath('cz_simple_cal') . 'Classes/Domain/Interface/HasTimespan.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Base.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Daily.php';
//require_once dirname(__FILE__).'/../../../Classes/Utility/DateTime.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Timeline/Base.php';
require_once dirname(__FILE__).'/../../../Mocks/class.MockHasTimespanClass.php';


/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Daily
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTypeDailyTest extends Tx_Extbase_BaseTestCase {
	
	public function testRecurranceUntil() {
		$event = new MockHasTimespanClass(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT')
		);
		
		$event->set('dateTimeObjectRecurranceUntil', new Tx_CzSimpleCal_Utility_DateTime('2009-02-14 23:59:59GMT'));
		
		$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		
		$typeDaily = new Tx_CzSimpleCal_Recurrance_Type_Daily();
		
		$return = $typeDaily->build($event, $timeline);
		
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
		$event = new MockHasTimespanClass(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-15 16:00:00GMT')
		);
		
		$event->set('dateTimeObjectRecurranceUntil', new Tx_CzSimpleCal_Utility_DateTime('2009-02-14 23:59:59GMT'));
		
		$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		
		$typeDaily = new Tx_CzSimpleCal_Recurrance_Type_Daily();
		
		$return = $typeDaily->build($event, $timeline);
		
		self::assertEquals(2, count($return->toArray()), 'exactly two event returned.');
	}
	
	
}
	