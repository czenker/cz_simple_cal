<?php

/**
 * testing the DateTime class
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Utility_DateTimeTest extends tx_phpunit_testcase {
	
	
	/**
	 * @dataProvider provideDataForConstructor
	 */
	public function testConstructorCompliance($format, $timezone = null) {
		if(is_null($timezone)) {
			$dateTime = new DateTime($format);
			$dateTimeExt = new Tx_CzSimpleCal_Utility_DateTime($format);
		} else {
			$dateTime = new DateTime($format, new DateTimeZone($timezone));
			$dateTimeExt = new Tx_CzSimpleCal_Utility_DateTime($format, new DateTimeZone($timezone));
		}
		self::assertEquals($dateTime->format('c'), $dateTimeExt->format('c'), 'constructors of DateTime and Utility_DateTime behave the same.');
	}
	
	public function provideDataForConstructor() {
		$array = array(
			array('2009-02-13 23:31:30'),
			array('2009-02-13 23:31:30', 'UTC'),
			array('2009-02-13 23:31:30', 'Europe/Berlin'),
			array('2009-02-13 23:31:30GMT'),
			array('2009-02-13 23:31:30GMT', 'Europe/Berlin'),
			array('@1234567890'),
			array('@1234567890', 'Europe/Berlin'),
		);
		$labels = array();
		foreach($array as $value) {
			$labels[] = isset($value[1]) ? 
				sprintf('%s and timezone %s', $value[0], $value[1]) :
				sprintf('%s', $value[0])
			; 
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDateForEnhancement
	 */
	public function testConstructorEnhancement($format, $expected) {
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime($format);
		$this->assertEquals($expected, $dateTime->format('U'));
	}
	
	/**
	 * @dataProvider provideDateForEnhancement
	 */
	public function testModifyEnhancement($format, $expected) {
		$format = explode('|', $format);
		$init = array_shift($format);
		$format = implode($format, '|');
		
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime($init);
		$dateTime->modify($format);
		$this->assertEquals($expected, $dateTime->format('U'));
	}
	
	public function provideDateForEnhancement() {
		$array = array(
//			array('first day this month', strtotime(strftime('%Y-%m-01 %H:%M:%S'))),
			array('@1234567890|first day this month', strtotime('2009-02-01 23:31:30GMT')),
			array('@1234567890|first day this month|monday this week', strtotime('2009-01-26 00:00:00GMT'))
		);
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf('%s is %s', $value[0], gmdate('c', $value[1]));
		}
		return array_combine($labels, $array);
	}
	
	
	
}