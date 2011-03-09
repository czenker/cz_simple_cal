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
	 * @dataProvider provideDataForFormats
	 */
	public function testRecognizedFormats($format, $expected) {
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime('@1234567890');
		$dateTime->modify($format);
		
		$this->assertEquals($expected, $dateTime->format('U'));
	}
	
	public function provideDataForFormats() {
		$array = array(
		    array('+1 second', 1234567890 + 1),
		    array('-1 second', 1234567890 - 1),
		    array('+1 minute', 1234567890 + 60),
		    array('-1 minute', 1234567890 - 60),
		    array('+1 hour', 1234567890 + 3600),
		    array('-1 hour', 1234567890 - 3600),
		    array('+1 day', 1234567890 + 86400),
		    array('-1 day', 1234567890 - 86400),
		    array('+1 week', 1234567890 + 7 * 86400),
		    array('-1 week', 1234567890 - 7 * 86400),
		    array('+1 month', 1234567890 + 28 * 86400),
		    array('-1 month', 1234567890 - 31 * 86400),
		    array('+1 year', 1234567890 + 365 * 86400),
		    array('-1 year', 1234567890 - 366 * 86400),
		    
		    array('yesterday', strtotime('2009-02-12 00:00:00GMT')),
		    array('today', strtotime('2009-02-13 00:00:00GMT')),
		    array('tomorrow', strtotime('2009-02-14 00:00:00GMT')),
		    
		    array('midnight', strtotime('2009-02-13 00:00:00GMT')),
		    array('noon', strtotime('2009-02-13 12:00:00GMT')),
		    
		    array('last monday', strtotime('2009-02-09 00:00:00GMT')),
		    array('next monday', strtotime('2009-02-16 00:00:00GMT')),
		    
		    array('monday this week', strtotime('2009-02-09 00:00:00GMT')),
		    array('monday last week', strtotime('2009-02-02 00:00:00GMT')),
		    array('monday next week', strtotime('2009-02-16 00:00:00GMT')),
		    array('sunday this week', strtotime('2009-02-15 00:00:00GMT')),
		    array('sunday last week', strtotime('2009-02-08 00:00:00GMT')),
		    array('sunday next week', strtotime('2009-02-22 00:00:00GMT')),
		    
		    array('first day of this month', strtotime('2009-02-01 23:31:30GMT')),
		    array('first day of last month', strtotime('2009-01-01 23:31:30GMT')),
		    array('first day of next month', strtotime('2009-03-01 23:31:30GMT')),
		    array('last day of this month', strtotime('2009-02-28 23:31:30GMT')),
		    array('last day of last month', strtotime('2009-01-31 23:31:30GMT')),
		    array('last day of next month', strtotime('2009-03-31 23:31:30GMT')),
		    
		    array('1st January this year', strtotime('2009-01-01 00:00:00GMT')),
		    array('1st January last year', strtotime('2008-01-01 00:00:00GMT')),
		    array('1st January next year', strtotime('2010-01-01 00:00:00GMT')),
		    array('31th December this year', strtotime('2009-12-31 00:00:00GMT')),
		    array('31th December last year', strtotime('2008-12-31 00:00:00GMT')),
		    array('31th December next year', strtotime('2010-12-31 00:00:00GMT')),
		    
		    array('2008/6/30', strtotime('2008-06-30 00:00:00GMT')),
		    array('2008/06/30', strtotime('2008-06-30 00:00:00GMT')),
		    array('2008-06-30', strtotime('2008-06-30 00:00:00GMT')),
		    array('30-06-2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('30.06.2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('30-June 2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('30-06-2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('30JUN08', strtotime('2008-06-30 00:00:00GMT')),
		    array('30 VI 2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('June 30th, 2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('June 30, 2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('June.30,08', strtotime('2008-06-30 00:00:00GMT')),
		    array('June.30,2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('Jun-30-08', strtotime('2008-06-30 00:00:00GMT')),
		    array('Jun-30-2008', strtotime('2008-06-30 00:00:00GMT')),
		    array('2008-Jun-30', strtotime('2008-06-30 00:00:00GMT')),
		    array('20080630', strtotime('2008-06-30 00:00:00GMT')),
		    array('08-06-30', strtotime('2008-06-30 00:00:00GMT')),
		    array('2008W273', strtotime('2008-07-02 00:00:00GMT')),
		    array('2008W27-3', strtotime('2008-07-02 00:00:00GMT')),
		    
		    array('4 am', strtotime('2009-02-13 04:00:00GMT')),
		    array('4:08 am', strtotime('2009-02-13 04:08:00GMT')),
		    array('4:08:37 am', strtotime('2009-02-13 04:08:37GMT')),
		    array('04:08', strtotime('2009-02-13 04:08:00GMT')),
		    array('04.08', strtotime('2009-02-13 04:08:00GMT')),
		    array('t04:08', strtotime('2009-02-13 04:08:00GMT')),
		    array('0408', strtotime('2009-02-13 04:08:00GMT')),
		    array('t0408', strtotime('2009-02-13 04:08:00GMT')),
		    array('04:08:37', strtotime('2009-02-13 04:08:37GMT')),
		    array('04.08.37', strtotime('2009-02-13 04:08:37GMT')),
		    array('040837', strtotime('2009-02-13 04:08:37GMT')),
		    array('040837CEST', strtotime('2009-02-13 02:08:37GMT')),
		    
		    array('2008-07-01T22:35:17', strtotime('2008-07-01 22:35:17GMT')),
		    array('@1215282385', strtotime('2008-07-05 18:26:25GMT')),
		);
		
		$labels = array();
		foreach($array as $value) {
			$labels[] = $value[0];
		}
		return array_combine($labels, $array);
	}
	
	/**
	 * @dataProvider provideDataForEnhancement
	 */
	public function testConstructorEnhancement($format, $expected) {
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime($format);
		$this->assertEquals($expected, $dateTime->format('U'));
	}
	
	/**
	 * @dataProvider provideDataForEnhancement
	 */
	public function testModifyEnhancement($format, $expected) {
		$format = explode('|', $format);
		$init = array_shift($format);
		$format = implode($format, '|');
		
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime($init);
		$dateTime->modify($format);
		$this->assertEquals($expected, $dateTime->format('U'));
	}
	
	public function provideDataForEnhancement() {
		$array = array(
//			array('first day this month', strtotime(strftime('%Y-%m-01 %H:%M:%S'))),
			array('@1234567890|first day of this month', strtotime('2009-02-01 23:31:30GMT')),
			array('@1234567890|first day of this month|monday this week', strtotime('2009-01-26 00:00:00GMT'))
		);
		$labels = array();
		foreach($array as $value) {
			$labels[] = sprintf('%s is %s', $value[0], gmdate('c', $value[1]));
		}
		return array_combine($labels, $array);
	}
	
	
	
}