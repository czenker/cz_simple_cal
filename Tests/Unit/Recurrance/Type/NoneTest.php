<?php 
//require_once 'PHPUnit/Framework.php';
//require_once dirname(__FILE__).'/../../../Classes/Domain/Interface/HasTimespan.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/Base.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Type/None.php';
//require_once dirname(__FILE__).'/../../../Classes/Utility/DateTime.php';
//require_once dirname(__FILE__).'/../../../Classes/Recurrance/Timeline/Base.php';

require_once dirname(__FILE__).'/../../../Mocks/class.MockHasTimespanClass.php';

/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_None
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTypeNoneTest extends Tx_Extbase_BaseTestCase {
	
	public function testBasic() {
		
		$event = new MockHasTimespanClass(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13 23:31:30GMT')
		);
		
		$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		
		$typeNone = new Tx_CzSimpleCal_Recurrance_Type_None();
		
		$return = $typeNone->build($event, $timeline);
		
		self::assertEquals(1, count($return->toArray()), 'exactly one event returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'this event equals the input settings');
	}
	
	
}
	