<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Format_DateTimeViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Format_DateTimeViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	
	protected $defaultTimezone = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Format_DateTimeViewHelper();
		
		$this->defaultTimezone = date_default_timezone_get();
		date_default_timezone_set('GMT');
	}
	
	public function tearDown() {
		date_default_timezone_set($this->defaultTimezone);
	}
	
	public function testTimestampParameter() {
		self::assertEquals(date('Y-m-d', time()), $this->viewHelper->render(null), 'if no timestamp is given the current time is used.');
		
		self::assertEquals('2009-02-13', $this->viewHelper->render(1234567890), 'integer values are excepted.');
		
		self::assertEquals('2009-02-13', $this->viewHelper->render('1234567890'), 'if string only contains numbers it is used as timestamp.');
		
		self::assertEquals('2009-02-13', $this->viewHelper->render('2009-02-13 23:31:30GMT'), 'if string does not only consist of numbers strtotime is used.');
		
		self::assertEquals('2009-02-13', $this->viewHelper->render(new DateTime('2009-02-13 23:31:30GMT')), 'DateTime objects are accepted.');
	}
	
	public function testFormatParameter() {
		self::assertEquals('2009-02-13 23:31:30', $this->viewHelper->render(1234567890, '%Y-%m-%d %H:%M:%S'), 'format can be set.');
		//@todo: not sure how to test localization of strings		
		
	}
	
	public function testGetParameter() {
		self::assertEquals('2009-02-14 23:31:30', $this->viewHelper->render(
			1234567890,
			'%Y-%m-%d %H:%M:%S',
			'+1 day'
		), 'adding one day works');
	}
	
}