<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Condition_OneNotEmptyViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Condition_OneNotEmptyViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $viewHelperVariableContainer = null;
	protected $viewHelperNode = null;
	
	
	public function setUp() {
		parent::setUp();
		
		$this->initViewHelper();
	}
	
	protected function initViewHelper() {
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Condition_OneNotEmptyViewHelper();
	}
	
	
	public function testEmptyValues() {
		self::assertSame(false, $this->viewHelper->render(array()), 'nothing at all');
		self::assertSame(false, $this->viewHelper->render(array('')), 'empty string');
		self::assertSame(false, $this->viewHelper->render(array(0)), '0');
		self::assertSame(false, $this->viewHelper->render(array(false)), 'boolean false');
		self::assertSame(false, $this->viewHelper->render(array('0')), 'string with a 0');
		self::assertSame(false, $this->viewHelper->render(array(array())), 'empty array');
	}
	
	public function testNonEmptyValues() {
		self::assertSame(true, $this->viewHelper->render(array('foobar')), 'non-empty string');
		self::assertSame(true, $this->viewHelper->render(array(42)), 'a positive integer');
		self::assertSame(true, $this->viewHelper->render(array(-42)), 'a negative integer');
		self::assertSame(true, $this->viewHelper->render(array(new stdClass())), 'a class');
		self::assertSame(true, $this->viewHelper->render(array(true)), 'boolean true');
	}
	
	public function testComplexExamples() {
		self::assertSame(false, $this->viewHelper->render(array(
			'',
			0,
			false
		)), 'just empty values');
		
		self::assertSame(true, $this->viewHelper->render(array(
			'',
			0,
			'foobar'
		)), 'non-empty value as last item');
		self::assertSame(true, $this->viewHelper->render(array(
			'foobar',
			0,
			false
		)), 'non-empty value as first item');
		self::assertSame(true, $this->viewHelper->render(array(
			'foobar',
			42,
			true
		)), 'just non-empty values');
	}

}