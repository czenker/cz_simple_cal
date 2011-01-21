<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Calendar_CreateDateViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Calendar_CreateDateTimeViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $viewHelperVariableContainer = null;
	protected $viewHelperNode = null;
	
	
	public function setUp() {
		parent::setUp();
		
		$this->initViewHelper();
	}
	
	protected function initViewHelper() {
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Calendar_CreateDateTimeViewHelper();
	}
	
	
	public function testBasic() {
		$dateTime = $this->viewHelper->render('2009-02-13 23:31:30GMT');
		
		self::assertTrue($dateTime instanceof Tx_CzSimpleCal_Utility_DateTime, 'returned object is an instance of Tx_CzSimpleCal_Utility_DateTime');
		self::assertEquals(1234567890, $dateTime->format('U'), 'object with correct time was created');
	}
}