<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the SetGlobalDataViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class SetGlobalDataViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $oldGlobalData = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_SetGlobalDataViewHelper();
		$this->oldGlobalData = $GLOBALS['TSFE']->cObj->data;
		
	}
	
	public function tearDown() {
		$GLOBALS['TSFE']->cObj->data = $this->oldGlobalData;
	}
	
	public function testBasic() {
		$this->viewHelper->render('foo', 'bar');
		self::assertEquals('bar', $GLOBALS['TSFE']->cObj->data['foo'], 'non-existant field is set');
		
		$this->viewHelper->render('foo', 'baz');
		self::assertEquals('baz', $GLOBALS['TSFE']->cObj->data['foo'], 'existant field is overriden');
	}
}