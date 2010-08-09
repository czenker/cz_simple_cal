<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Calendar_OnNewDayViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Calendar_OnNewDayViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $viewHelperVariableContainer = null;
	protected $viewHelperNode = null;
	
	
	public function setUp() {
		parent::setUp();
		
		$this->initViewHelper();
	}
	
	protected function initViewHelper() {
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Calendar_OnNewDayViewHelper();
		$this->viewHelperVariableContainer = new Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer();
		$this->viewHelperNode = $this->getMock('Tx_Fluid_Core_Parser_SyntaxTree_ViewHelperNode', array(), array(), '', false);
		$this->viewHelperNode->expects($this->any())
        	->method('evaluateChildNodes')
        	->will($this->returnValue('tag content'))
        ;
		
		$this->viewHelper->setViewHelperVariableContainer($this->viewHelperVariableContainer);
		$this->viewHelper->setViewHelperNode($this->viewHelperNode);
	}
	
	
	public function testIfContentIsRenderedIfNoViewHelperWasPreviouslyUsed() {
		
		$model = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		$model->setStart(1234567890);
		$model->setEnd(1234567890);
		
		self::assertSame('tag content', $this->viewHelper->render($model));
	}
	
	public function testIfContentIsNotRenderedIfLastViewHelperWasOnSameDay() {
		
		$model = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		$model->setStart(1234567890);
		$model->setEnd(1234567890);
		
		$this->viewHelper->render($model);
		
		self::assertSame('', $this->viewHelper->render($model));
	}
	
	public function testIfContentIsRenderedIfLastViewHelperWasOnEarlierDay() {
		
		$model = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		$model->setStart(1234567890);
		$model->setEnd(1234567890);
		
		$this->viewHelper->render($model);

		$model = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		$model->setStart(1234567890 + 86400);
		$model->setEnd(1234567890 + 86400);
		
		self::assertSame('tag content', $this->viewHelper->render($model));
	}
	
	public function testMultipleIrelatedInstances() {
		$model = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		$model->setStart(1234567890);
		$model->setEnd(1234567890);
		
		$this->viewHelper->render($model);
		
		self::assertSame('tag content', $this->viewHelper->render($model, 'foobar'));
	}
	
}