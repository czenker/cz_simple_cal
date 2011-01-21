<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the UseMicroformatViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class UseMicroformatTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $oldHeaderData = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_UseMicroformatViewHelper();
		$this->oldHeaderData = $GLOBALS['TSFE']->additionalHeaderData;
	}
	
	public function tearDown() {
		$GLOBALS['TSFE']->additionalHeaderData = $this->oldHeaderData;
	}
	
	public function testCustomUri() {
		$uri = 'http://www.example.com/my-microformat';
		$this->viewHelper->render($uri);
		
		$changedData = $this->getChangedHeaderData();
		
		self::assertFalse(empty($changedData) || !is_array($changedData), 'some header data was added');
		self::assertEquals(1, count($changedData), 'exactly one line was added to the header data');
		
		self::assertContains($uri, current($changedData), 'the correct uri of the microformat was added');
		
		
		// add the same microformat again
		$this->viewHelper->render($uri);
		$changedData = $this->getChangedHeaderData();
		self::assertEquals(1, count($changedData), 'the same microformat won\'t be added a second time');
		
		
		// add a different microformat
		$this->viewHelper->render($uri.'2');
		$changedData = $this->getChangedHeaderData();
		self::assertFalse(empty($changedData) || !is_array($changedData), 'headerData is still an array after adding a second microformat');
		self::assertEquals(2, count($changedData), 'a second microformat gets added');
	}
	
	public function testPredefinedUri() {
		
		$this->viewHelper->render('hcard');
		
		$changedData = $this->getChangedHeaderData();
		
		self::assertFalse(empty($changedData) || !is_array($changedData), 'some header data was added');
		self::assertEquals(1, count($changedData), 'exactly one line was added to the header data');
		
		self::assertContains('http://microformats.org/', current($changedData), 'known microformats get substituted');
		
	}
	
	/**
	 * get all entries of an array, with keys that were added during the run of the test
	 * (it won't recognized changed content of a key!)
	 * 
	 * @return array
	 */
	protected function getChangedHeaderData() {
		if(is_null($this->oldHeaderData) || !is_array($this->oldHeaderData)) {
			return is_array($GLOBALS['TSFE']->additionalHeaderData) ? 
				$GLOBALS['TSFE']->additionalHeaderData :
				array()
			;
		} else {
			return array_diff($GLOBALS['TSFE']->additionalHeaderData, $this->oldHeaderData);
		}
	}
}