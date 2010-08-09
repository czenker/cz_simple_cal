<?php

/**
 * testing the Config class
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class ConfigTest extends tx_phpunit_testcase {
	
	/**
	 * stores the GLOBALS array
	 * 
	 * @var array
	 */
	protected $oldGlobals = null;
	
	
	public function setUp() {
		$this->oldGlobals = $GLOBALS;
		$GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cz_simple_cal'] = serialize(array('foo' => 'bar'));
	}
	
	public function tearDown() {
		$GLOBALS = $this->oldGlobals;
	}
	
	public function testInitialization() {
		self::assertTrue(Tx_CzSimpleCal_Utility_Config::exists('foo'), 'field is existant');
		self::assertEquals('bar', Tx_CzSimpleCal_Utility_Config::get('foo'), 'field has correct value');
	}
	
	public function testSetter() {
		Tx_CzSimpleCal_Utility_Config::set('foo', 'baz');
		self::assertEquals('baz', Tx_CzSimpleCal_Utility_Config::get('foo'), 'setting of existant values works');
		
		Tx_CzSimpleCal_Utility_Config::set('baz', 'foo');
		self::assertEquals('foo', Tx_CzSimpleCal_Utility_Config::get('baz'), 'setting of non-existant values works');
		
		Tx_CzSimpleCal_Utility_Config::set(array('hello' => 'world'));
		self::assertEquals('world', Tx_CzSimpleCal_Utility_Config::get('hello'), 'setting of an array');
	}
	
}