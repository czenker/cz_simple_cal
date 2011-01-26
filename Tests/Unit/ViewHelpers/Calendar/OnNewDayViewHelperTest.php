<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
require_once(t3lib_extmgm::extPath('cz_simple_cal') . 'Classes/ViewHelpers/Calendar/OnNewDayViewHelper.php');
 
/**
 * testing the features of the Calendar_OnNewDayViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Calendar_OnNewDayViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $viewHelperVariableContainer = null;
	
	
	public function setUp() {
		parent::setUp();
		
		$this->initViewHelper();
	}
	
	protected function initViewHelper() {
		$this->viewHelper = new Tx_CzSimpleCalTests_Mocks_ViewHelpers_Calendar_OnNewDayViewHelper();
		
		$this->viewHelperVariableContainer = new Tx_Fluid_Core_ViewHelper_ViewHelperVariableContainer();
		
		$this->viewHelper->setViewHelperVariableContainer($this->viewHelperVariableContainer);
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

class Tx_CzSimpleCalTests_Mocks_ViewHelpers_Calendar_OnNewDayViewHelper extends Tx_CzSimpleCal_ViewHelpers_Calendar_OnNewDayViewHelper {
	protected function renderChildren() {
		return 'tag content';
	}
}