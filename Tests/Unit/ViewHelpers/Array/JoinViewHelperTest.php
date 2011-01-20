<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Array_JoinViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Array_JoinViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Array_JoinViewHelper();
		
	}
	
	public function testBasic() {
		self::assertEquals('foo, bar',$this->viewHelper->render(array('foo', 'bar')), 'default imploder is ", "');
	}
	
	public function testByParameter() {
		self::assertEquals('foo#bar',$this->viewHelper->render(array('foo', 'bar'), '#'), '"by" parameter is recognized');
	}
	
	public function testRemoveEmptyParameter() {
		self::assertEquals('foo##bar',$this->viewHelper->render(array('foo', '', 'bar'), '#'), 'empty values are not removed by default');
		self::assertEquals('foo#bar',$this->viewHelper->render(array('foo', '', 'bar'), '#', true), 'empty values can be removed');
	}
	
}