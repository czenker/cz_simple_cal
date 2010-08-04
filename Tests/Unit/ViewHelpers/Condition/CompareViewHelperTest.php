<?php 
require_once 'PHPUnit/Framework.php';
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Condition_CompareViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Condition_CompareViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Condition_CompareViewHelper();
	}
	
	public function testBasic() {
		self::assertEquals(true, $this->viewHelper->render(1,1));
	}
	
	public function testIfErrorIsThrownOnUnknownOperation() {
		$this->setExpectedException('InvalidArgumentException');
		
		$this->viewHelper->render(1,1,'!#*');
	}
	
	public function testIntegers() {
		self::assertEquals(true, $this->viewHelper->render(1,1,'='), '"1 = 1" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,2,'='), '"1 = 2" returns false');
		
		self::assertEquals(true, $this->viewHelper->render(1,1,'=='), '"1 == 1" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,2,'=='), '"1 == 2" returns false');
		
		self::assertEquals(true, $this->viewHelper->render(1,1,'==='), '"1 === 1" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,2,'==='), '"1 === 2" returns false');
		
		self::assertEquals(true, $this->viewHelper->render(1,2,'!='), '"1 != 2" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,1,'!='), '"1 != 1" returns false');
		
		self::assertEquals(true, $this->viewHelper->render(1,2,'<>'), '"1 <> 2" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,1,'<>'), '"1 <> 1" returns false');
		
		self::assertEquals(true, $this->viewHelper->render(1,2,'!=='), '"1 !== 2" returns true');
		self::assertEquals(false, $this->viewHelper->render(1,1,'!=='), '"1 !== 1" returns false');
		
		self::assertEquals(false, $this->viewHelper->render(1,2,'>'), '"1 > 2" returns false');
		self::assertEquals(false, $this->viewHelper->render(1,1,'>'), '"1 > 1" returns false');
		self::assertEquals(true, $this->viewHelper->render(1,0,'>'), '"1 > 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render(1,2,'>='), '"1 >= 2" returns false');
		self::assertEquals(true, $this->viewHelper->render(1,1,'>='), '"1 >= 1" returns true');
		self::assertEquals(true, $this->viewHelper->render(1,0,'>='), '"1 >= 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render(1,2,'=>'), '"1 => 2" returns false');
		self::assertEquals(true, $this->viewHelper->render(1,1,'=>'), '"1 => 1" returns true');
		self::assertEquals(true, $this->viewHelper->render(1,0,'=>'), '"1 => 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render(2,1,'<'), '"2 < 1" returns false');
		self::assertEquals(false, $this->viewHelper->render(1,1,'<'), '"1 < 1" returns false');
		self::assertEquals(true, $this->viewHelper->render(0,1,'<'), '"0 < 1" returns true');
		
		self::assertEquals(false, $this->viewHelper->render(2,1,'<='), '"2 <= 1" returns false');
		self::assertEquals(true, $this->viewHelper->render(1,1,'<='), '"1 <= 1" returns true');
		self::assertEquals(true, $this->viewHelper->render(0,1,'<='), '"0 <= 1" returns true');
		
		self::assertEquals(false, $this->viewHelper->render(2,1,'=<'), '"2 =< 1" returns false');
		self::assertEquals(true, $this->viewHelper->render(1,1,'=<'), '"1 =< 1" returns true');
		self::assertEquals(true, $this->viewHelper->render(0,1,'=<'), '"0 =< 1" returns true');
	}
	
	public function testStringVsInteger() {
		self::assertEquals(true, $this->viewHelper->render('1',1,'='), '"\'1\' = 1" returns true');
		self::assertEquals(false, $this->viewHelper->render('1',2,'='), '"\'1\' = 2" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('1',1,'=='), '"\'1\' == 1" returns true');
		self::assertEquals(false, $this->viewHelper->render('1',2,'=='), '"\'1\' == 2" returns false');
		
		self::assertEquals(false, $this->viewHelper->render('1',1,'==='), '"\'1\' === 1" returns false');
		self::assertEquals(false, $this->viewHelper->render('1',2,'==='), '"\'1\' === 2" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('1',2,'!='), '"\'1\' != 2" returns true');
		self::assertEquals(false, $this->viewHelper->render('1',1,'!='), '"\'1\' != 1" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('1',2,'<>'), '"\'1\' <> 2" returns true');
		self::assertEquals(false, $this->viewHelper->render('1',1,'<>'), '"\'1\' <> 1" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('1',2,'!=='), '"\'1\' !== 2" returns true');
		self::assertEquals(true, $this->viewHelper->render('1',1,'!=='), '"\'1\' !== 1" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('1',2,'>'), '"\'1\' > 2" returns false');
		self::assertEquals(false, $this->viewHelper->render('1',1,'>'), '"\'1\' > 1" returns false');
		self::assertEquals(true, $this->viewHelper->render('1',0,'>'), '"\'1\' > 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('1',2,'>='), '"\'1\' >= 2" returns false');
		self::assertEquals(true, $this->viewHelper->render('1',1,'>='), '"\'1\' >= 1" returns true');
		self::assertEquals(true, $this->viewHelper->render('1',0,'>='), '"\'1\' >= 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('1',2,'=>'), '"\'1\' => 2" returns false');
		self::assertEquals(true, $this->viewHelper->render('1',1,'=>'), '"\'1\' => 1" returns true');
		self::assertEquals(true, $this->viewHelper->render('1',0,'=>'), '"\'1\' => 0" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('2',1,'<'), '"\'2\' < 1" returns false');
		self::assertEquals(false, $this->viewHelper->render('1',1,'<'), '"\'1\' < 1" returns false');
		self::assertEquals(true, $this->viewHelper->render('0',1,'<'), '"\'0\' < 1" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('2',1,'<='), '"\'2\' <= 1" returns false');
		self::assertEquals(true, $this->viewHelper->render('1',1,'<='), '"\'1\' <= 1" returns true');
		self::assertEquals(true, $this->viewHelper->render('0',1,'<='), '"\'0\' <= 1" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('2',1,'=<'), '"\'2\' =< 1" returns false');
		self::assertEquals(true, $this->viewHelper->render('1',1,'=<'), '"\'1\' =< 1" returns true');
		self::assertEquals(true, $this->viewHelper->render('0',1,'=<'), '"\'0\' =< 1" returns true');
	}
	
	public function testStrings() {
		self::assertEquals(true, $this->viewHelper->render('foo','foo','='), '"\'foo\' = \'foo\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','='), '"\'foo\' = \'bar\'" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','=='), '"\'foo\' == \'foo\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','=='), '"\'foo\' == \'bar\'" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','==='), '"\'foo\' === \'foo\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','==='), '"\'foo\' === \'bar\'" returns false');
		
		self::assertEquals(false, $this->viewHelper->render('foo','foo','!='), '"\'foo\' != \'foo\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','!='), '"\'foo\' != \'bar\'" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('foo','foo','<>'), '"\'foo\' <> \'foo\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','<>'), '"\'foo\' <> \'bar\'" returns true');

		self::assertEquals(false, $this->viewHelper->render('foo','foo','!=='), '"\'foo\' !== \'foo\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','!=='), '"\'foo\' !== \'bar\'" returns true');
		
		self::assertEquals(false, $this->viewHelper->render('foo','foo','>'), '"\'foo\' > \'foo\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','>'), '"\'foo\' > \'bar\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('bar','baz','>'), '"\'bar\' > \'baz\'" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','>='), '"\'foo\' >= \'foo\'" returns true');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','>='), '"\'foo\' >= \'bar\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('bar','baz','>='), '"\'bar\' >= \'baz\'" returns false');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','=>'), '"\'foo\' => \'foo\'" returns true');
		self::assertEquals(true, $this->viewHelper->render('foo','bar','=>'), '"\'foo\' => \'bar\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('bar','baz','=>'), '"\'bar\' => \'baz\'" returns false');
		
		self::assertEquals(false, $this->viewHelper->render('foo','foo','<'), '"\'foo\' < \'foo\'" returns false');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','<'), '"\'foo\' < \'bar\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('bar','baz','<'), '"\'bar\' < \'baz\'" returns true');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','<='), '"\'foo\' <= \'foo\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','<='), '"\'foo\' <= \'bar\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('bar','baz','<='), '"\'bar\' <= \'baz\'" returns true');
		
		self::assertEquals(true, $this->viewHelper->render('foo','foo','=<'), '"\'foo\' =< \'foo\'" returns true');
		self::assertEquals(false, $this->viewHelper->render('foo','bar','=<'), '"\'foo\' =< \'bar\'" returns false');
		self::assertEquals(true, $this->viewHelper->render('bar','baz','=<'), '"\'bar\' =< \'baz\'" returns true');
	}
}