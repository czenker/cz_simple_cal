<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Condition_CompareViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Condition_CompareViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	protected $viewHelperVariableContainer = null;
	protected $viewHelperNode = null;
	
	
	public function setUp() {
		parent::setUp();
		
		$this->initViewHelper();
	}
	
	protected function initViewHelper() {
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Condition_CompareViewHelper();
	}
	
	/**
	 * @dataProvider provideDataForEquals
	 */
	public function testEquals($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '='));
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '=='));
	}
	
	public function provideDataForEquals() {
		$array = array(
			array(true, true, true),
			array(true, 42, true),
			array(true, '42', true),
			array(true, 42.00, true),
			array(false, 0, true),
			array(false, '', true),
			array(42, 42, true),
			array(42, '42', true),
			array(42, 42.00, true),
			array('42', 42.00, true),
			
			array(false, true, false),
			array(false, 42, false),
			array(false, '42', false),
			array(false, 42.00, false),
			array(4, 2, false),
			array(42, 'foobar', false),
			array(42, 42.0001, false),
			array('foobar', 42.00, false),
		);
		
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf(
				'%s == %s evaluates %s',
				$this->renderValue($value[0]),
				$this->renderValue($value[1]),
				$value[2] ? 'true' : 'false'
			);
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDataForSame
	 */
	public function testSame($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '==='));
	}
	
	public function provideDataForSame() {
		$array = array(
			array(true, true, true),
			array(true, 42, false),
			array(true, '42', false),
			array(true, 42.00, false),
			array(false, 0, false),
			array(false, '', false),
			array(42, 42, true),
			array(42, '42', false),
			array(42, 42.00, false),
			array('42', 42.00, false),
			
			array(false, true, false),
			array(false, 42, false),
			array(false, '42', false),
			array(false, 42.00, false),
			array(4, 2, false),
			array(42, 'foobar', false),
			array(42, 42.0001, false),
			array('foobar', 42.00, false),
		);
		
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf(
				'%s === %s evaluates %s',
				$this->renderValue($value[0]),
				$this->renderValue($value[1]),
				$value[2] ? 'true' : 'false'
			);
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDataForNotEquals
	 */
	public function testNotEquals($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '!='));
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '<>'));
	}
	
	public function provideDataForNotEquals() {
		$array = $this->provideDataForEquals();
		$outArray = array();
		
		foreach($array as $label => $config) {
			$label = strtr($label, array(
				'==' => '!=',
				'evaluates true' => 'evaluates false',
				'evaluates false' => 'evaluates true',
			));
			$outArray[$label] = array(
				$config[0],
				$config[1],
				!$config[2]
			);
		}
		return $outArray;
	}
	
	
	
	/**
	 * @dataProvider provideDataForNotSame
	 */
	public function testNotSame($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '!=='));
	}
	
	public function provideDataForNotSame() {
		$array = $this->provideDataForSame();
		$outArray = array();
		
		foreach($array as $label => $config) {
			$label = strtr($label, array(
				'===' => '!==',
				'evaluates true' => 'evaluates false',
				'evaluates false' => 'evaluates true',
			));
			$outArray[$label] = array(
				$config[0],
				$config[1],
				!$config[2]
			);
		}
		return $outArray;
	}
	
	/**
	 * @dataProvider provideDataForGreaterThan
	 */
	public function testGreaterThan($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '>'));
	}
	
	public function provideDataForGreaterThan() {
		$array = array(
			array(true, true, false),
			array(false, false, false),
			array(true, 42, false),
			array(true, '42', false),
			array(true, 42.00, false),
			array(false, 0, false),
			array(false, '', false),
			array(42, 42, false),
			array(42, '42', false),
			array(42, 42.00, false),
			array('42', 42.00, false),
			
			array(true, false, true),
			array(4, 2, true),
			array('4', 2, true),
			array(4.00, 2, true),
			array(pi(), 2, true),
			
			array(false, true, false),
			array(2, 4, false),
			array(2, '4', false),
			array(2, 4.00, false),
			array(2, pi(), false),
		);
		
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf(
				'%s &gt; %s evaluates %s',
				$this->renderValue($value[0]),
				$this->renderValue($value[1]),
				$value[2] ? 'true' : 'false'
			);
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDataForGreaterThanEquals
	 */
	public function testGreaterThanEquals($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '>='));
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '=>'));
	}
	
	public function provideDataForGreaterThanEquals() {
		$array = array(
			array(true, true, true),
			array(false, false, true),
			array(true, 42, true),
			array(true, '42', true),
			array(true, 42.00, true),
			array(false, 0, true),
			array(false, '', true),
			array(42, 42, true),
			array(42, '42', true),
			array(42, 42.00, true),
			array('42', 42.00, true),
			
			array(true, false, true),
			array(4, 2, true),
			array('4', 2, true),
			array(4.00, 2, true),
			array(pi(), 2, true),
			
			array(false, true, false),
			array(2, 4, false),
			array(2, '4', false),
			array(2, 4.00, false),
			array(2, pi(), false),
		);
		
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf(
				'%s &gt;= %s evaluates %s',
				$this->renderValue($value[0]),
				$this->renderValue($value[1]),
				$value[2] ? 'true' : 'false'
			);
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDataForLessThan
	 */
	public function testLessThan($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '<'));
	}
	
	public function provideDataForLessThan() {
		$array = $this->provideDataForGreaterThanEquals();
		$outArray = array();
		
		foreach($array as $label => $config) {
			$label = strtr($label, array(
				'&gt;=' => '&lt;',
				'evaluates true' => 'evaluates false',
				'evaluates false' => 'evaluates true',
			));
			$outArray[$label] = array(
				$config[0],
				$config[1],
				!$config[2]
			);
		}
		return $outArray;
	}
	
	/**
	 * @dataProvider provideDataForLessThanEquals
	 */
	public function testLessThanEquals($value1, $value2, $expected) {
		self::assertSame($expected, $this->viewHelper->render($value1, $value2, '<='));
	}
	
	public function provideDataForLessThanEquals() {
		$array = $this->provideDataForGreaterThan();
		$outArray = array();
		
		foreach($array as $label => $config) {
			$label = strtr($label, array(
				'&gt;' => '&lt;=',
				'evaluates true' => 'evaluates false',
				'evaluates false' => 'evaluates true',
			));
			$outArray[$label] = array(
				$config[0],
				$config[1],
				!$config[2]
			);
		}
		return $outArray;
	}
	
	
	/**
	 * helps rendering a value and its type for atomic values
	 * 
	 * @param mixed $value
	 * @return string
	 */
	protected function renderValue($value) {
		if(is_bool($value)) {
			return sprintf('boolean: %b', $value);
		} elseif(is_integer($value)) {
			return sprintf('integer: %d', $value);
		} elseif(is_float($value)) {
			return sprintf('integer: %f', $value);
		} elseif(is_string($value)) {
			return sprintf('string: "%s"', $value);
		}
	}
}