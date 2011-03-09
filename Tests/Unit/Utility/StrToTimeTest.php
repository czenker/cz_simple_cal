<?php 
 
/**
 * testing the features of StrToTime
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 * @see http://www.php.net/manual/en/datetime.formats.relative.php
 */
class StrToTimeTest extends tx_phpunit_testcase
{
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
                $buffer .= sprintf(' with data set "%s"',$this->data[0]);;
            } else {
                $buffer .= sprintf(' with data set "%s"', $this->dataName);
            }

            if ($includeData) {
                $buffer .= sprintf(' (%s)', $this->dataToString($this->data));
            }
        }

        return $buffer;
    }
    
    
	protected $dateTime = null;
	
	protected $defaultTimezone = null;
	
	public function setUp() {
		$this->dateTime = strtotime('2009-02-13 23:31:30GMT'); // a friday
	
		$this->defaultTimezone = date_default_timezone_get();
		date_default_timezone_set('GMT');
	}
	
	public function tearDown() {
		date_default_timezone_set($this->defaultTimezone);
	}
	
	/**
	 * @test
	 */
    public function testBasic() {
    	self::assertEquals(1234567890, $this->dateTime, 'this test is set up correctly');
    }
    
    /**
     * @dataProvider provider
     */
    public function testModifications($modification, $assumed) {
    	
    	self::assertEquals(
    		$assumed,
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime($modification, $this->dateTime)
    	);
    }
    
    public function provider() {
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
    		
    		// test for compound dates
    		array('first day of this month | monday this week', strtotime('2009-01-26 00:00:00GMT')),
    	);
    	
    	$labels = array();
		foreach($array as $value) {
			$labels[] = 'with data '.$value[0];
		}
		return array_combine($labels, $array);
    }
    
    public function testWeeksStartWithMonday() {
    	self::assertEquals(
    		strtotime('2009-02-02 00:00:00GMT'),
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime('monday this week', strtotime('2009-02-08 00:00:00')),
    		'"monday this week" when on a sunday'
    	);
    	
    	self::assertEquals(
    		strtotime('2009-02-02 00:00:00GMT'),
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime('monday this week', strtotime('2009-02-02 00:00:00')),
    		'"monday this week" when on a monday'
    	);
    	
    	self::assertEquals(
    		strtotime('2009-02-08 00:00:00GMT'),
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime('sunday this week', strtotime('2009-02-08 00:00:00')),
    		'"sunday this week" when on a sunday'
    	);
    	
    	self::assertEquals(
    		strtotime('2009-02-08 00:00:00GMT'),
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime('sunday this week', strtotime('2009-02-02 00:00:00')),
    		'"sunday this week" when on a monday'
    	);
    	
    	self::assertEquals(
    		strtotime('2009-12-28 00:00:00GMT'),
    		Tx_CzSimpleCal_Utility_StrToTime::strtotime('monday this week', strtotime('2010-01-01 00:00:00')),
    		'"monday this week" on a year switch'
    	);
    }
    
}