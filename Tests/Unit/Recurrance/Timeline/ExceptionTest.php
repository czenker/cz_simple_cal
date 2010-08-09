<?php 
 
/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Timeline_Event
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTimlineExceptionTest extends Tx_Extbase_BaseTestCase {
	
	/**
	 * @var Tx_CzSimpleCal_Recurrance_Timeline_Exception
	 */
	protected $timeline = null;
	
	public function setUp() {
		$this->timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Exception();
	}
	
	public function testInheritance() {
		self::assertTrue($this->timeline instanceof Tx_CzSimpleCal_Recurrance_Timeline_Base, 'inherits from Tx_CzSimpleCal_Recurrance_Timeline_Base');
	}
	
	public function testTimespansWithSameStart() {
		
		try {
			
			$this->timeline->add(array(
				'start' => strtotime('2009-02-13 23:31:30GMT'),
				'end' => strtotime('2009-02-13 23:31:31GMT')
			));
			
			$this->timeline->add(array(
				'start' => strtotime('2009-02-13 23:31:30GMT'),
				'end' => strtotime('2009-02-14 00:00:00GMT')
			));
			
			$this->timeline->add(array(
				'start' => strtotime('2009-02-13 23:31:30GMT'),
				'end' => strtotime('2009-02-13 23:45:00GMT')
			));
		} catch(Exception $e) {
			self::assertTrue(false, 'adding two equal exceptions won\'t throw an error.');
			return;
		}
		
		self::assertSame(1, $this->timeline->count(), 'only one exception stored if there was a different one with same start.');
		
		$current = $this->timeline->current();
		self::assertSame(strtotime('2009-02-14 00:00:00GMT'), $current['end'], 'end of the longest event was stored');
		
		
	}
	
}