<?php 
require_once dirname(__FILE__).'/../../../Mocks/IsRecurringMock.php';

/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Type_Weekly
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCalTests_Recurrance_Type_NoneTest extends Tx_Extbase_BaseTestCase {
	
	protected function buildRecurrance($event, $timeline = null) {
		if(is_null($timeline)) {
			$timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		}
		$typeNone = new Tx_CzSimpleCal_Recurrance_Type_None();
		
		return $typeNone->build($event, $timeline);
	}
	
	public function testBasic() {
		$event = Tx_CzSimpleCalTests_Mocks_IsRecurringMock::fromArray(array(
			'start'           => '2009-02-13 23:31:30GMT',
			'end'             => '2009-02-13 23:31:30GMT'
		));
		
		$return = $this->buildRecurrance($event);
		
		self::assertEquals(1, count($return->toArray()), 'exactly one event returned');
		self::assertEquals(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end'   => strtotime('2009-02-13 23:31:30GMT')
		), $return->current(), 'the event equals the input settings');
	}
}
	