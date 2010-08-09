<?php

/**
 * testing the DateTime class
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Utility_DateTimeTest extends tx_phpunit_testcase {
	
	/**
     * Gets the data set description of a TestCase.
     *
     * @param  boolean $includeData
     * @return string
     * @since  Method available since Release 3.3.0
     */
    protected function getDataSetAsString($includeData = TRUE) {
    	$buffer = '';

        if (!empty($this->data)) {
            if (is_int($this->dataName)) {
                $buffer .= sprintf(' with data set "%s" and timezone %s',$this->data[0], $this->data[1] ? '"'.$this->data[1].'"' : "null");
            } else {
                $buffer .= sprintf(' with data set "%s"', $this->dataName);
            }

            if ($includeData) {
                $buffer .= sprintf(' (%s)', $this->dataToString($this->data));
            }
        }

        return $buffer;
    }
	
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
		return array(
			array('2009-02-13 23:31:30'),
			array('2009-02-13 23:31:30', 'UTC'),
			array('2009-02-13 23:31:30', 'Europe/Berlin'),
			array('2009-02-13 23:31:30GMT'),
			array('2009-02-13 23:31:30GMT', 'Europe/Berlin'),
			array('@1234567890'),
			array('@1234567890', 'Europe/Berlin'),
		);
	}
	
	public function testConstructorRecognizesEnhancedStrToTime() {
		$format = 'first day this month';
		if(version_compare(PHP_VERSION, '5.3.0') >= 0) {
			$format = Tx_CzSimpleCal_Utility_StrToTime::doPHP52Substitutions($format);
		}
		$dateTime = new Tx_CzSimpleCal_Utility_DateTime($format, new DateTimeZone('UTC'));
				
		self::assertEquals(gmdate('Y-m-01\TH:i:s+00:00') , $dateTime->format('c'));
		
	}
	
}