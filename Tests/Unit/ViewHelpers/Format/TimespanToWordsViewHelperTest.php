<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
require_once(t3lib_extmgm::extPath('cz_simple_cal') . 'Tests/Mocks/ViewHelpers/Format/TimespanToWordsViewHelper.php');
 
/**
 * testing the features of the Format_TimespanToWordsViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Format_TimespanToWordsViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCalTests_Mock_ViewHelpers_Format_TimespanToWordsViewHelper();
		
	}
	
	public function testOnOneDay() {
		self::assertEquals('on February 13, 2009', $this->viewHelper->render(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13')
		));
	}
	
	public function testOnOneMonth() {
		self::assertEquals('from February 13 to 15, 2009', $this->viewHelper->render(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-15')
		));
	}
	
	public function testOnOneYear() {
		self::assertEquals('from February 13 to March 15, 2009', $this->viewHelper->render(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13'),
			new Tx_CzSimpleCal_Utility_DateTime('2009-03-15')
		));
	}
	
	public function testElse() {
		self::assertEquals('from February 13, 2009 to March 15, 2010', $this->viewHelper->render(
			new Tx_CzSimpleCal_Utility_DateTime('2009-02-13'),
			new Tx_CzSimpleCal_Utility_DateTime('2010-03-15')
		));
	}
	
}