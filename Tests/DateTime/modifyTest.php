<?php 
require_once 'PHPUnit/Framework.php';
 
/**
 * testing the features of DateTime::modify()
 * 
 * they might differ in different PHP versions.
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 * @see http://www.php.net/manual/en/datetime.formats.relative.php
 */
class DateTimeModifyTest extends PHPUnit_Framework_TestCase
{
	
	protected $dateTime = null;
	
	public function setUp() {
		$this->dateTime = new DateTime('2009-02-13 23:31:30GMT'); // a friday
	}
	
    public function testBasic() {
    	self::assertEquals(1234567890, $this->dateTime->format('U'), 'this test is set up correctly');
    }
    
	public function testAddSecond() {
    	$this->dateTime->modify('+1 second');
    	self::assertEquals(1234567890 + 1, $this->dateTime->format('U'), '+1 second');
    }
    
 	public function testSubtractSecond() {
    	$this->dateTime->modify('-1 second');
    	self::assertEquals(1234567890 - 1, $this->dateTime->format('U'), '-1 second');
    }
    
	public function testAddMinute() {
    	$this->dateTime->modify('+1 minute');
    	self::assertEquals(1234567890 + 60, $this->dateTime->format('U'), '+1 minute');
    }
    
 	public function testSubtractMinute() {
    	$this->dateTime->modify('-1 minute');
    	self::assertEquals(1234567890 - 60, $this->dateTime->format('U'), '-1 minute');
    }
    
	public function testAddHour() {
    	$this->dateTime->modify('+1 hour');
    	self::assertEquals(1234567890 + 3600, $this->dateTime->format('U'), '+1 hour');
    }
    
 	public function testSubtractHour() {
    	$this->dateTime->modify('-1 hour');
    	self::assertEquals(1234567890 - 3600, $this->dateTime->format('U'), '-1 hour');
    }
    
    public function testAddDay() {
    	$this->dateTime->modify('+1 day');
    	self::assertEquals(1234567890 + 86400, $this->dateTime->format('U'), '+1 day');
    }
    
 	public function testSubtractDay() {
    	$this->dateTime->modify('-1 day');
    	self::assertEquals(1234567890 - 86400, $this->dateTime->format('U'), '-1 day');
    }
    
    public function testAddWeekday() {
    	$this->dateTime->modify('+1 weekday');
    	self::assertEquals(1234567890 + 3 * 86400, $this->dateTime->format('U'), '+1 weekday');
    }
    
 	public function testSubtractWeekDay() {
    	$this->dateTime->modify('-1 weekday');
    	self::assertEquals(1234567890 - 86400, $this->dateTime->format('U'), '-1 weekday');
    }
    
	public function testAddWeek() {
    	$this->dateTime->modify('+1 week');
    	self::assertEquals(1234567890 + 7 * 86400, $this->dateTime->format('U'), '+1 week');
    }
    
 	public function testSubtractWeek() {
    	$this->dateTime->modify('-1 week');
    	self::assertEquals(1234567890 - 7 * 86400, $this->dateTime->format('U'), '-1 week');
    }
    
	public function testAddFortnight() {
    	$this->dateTime->modify('+1 fortnight');
    	self::assertEquals(1234567890 + 14 * 86400, $this->dateTime->format('U'), '+1 fortnight');
    }
    
 	public function testSubtractFortnight() {
    	$this->dateTime->modify('-1 fortnight');
    	self::assertEquals(1234567890 - 14 * 86400, $this->dateTime->format('U'), '-1 fortnight');
    }
    
	public function testAddMonth() {
    	$this->dateTime->modify('+1 month');
    	self::assertEquals(1234567890 + 28 * 86400, $this->dateTime->format('U'), '+1 month');
    }
    
 	public function testSubtractMonth() {
    	$this->dateTime->modify('-1 month');
    	self::assertEquals(1234567890 - 31 * 86400, $this->dateTime->format('U'), '-1 month');
    }
    
	public function testAddYear() {
    	$this->dateTime->modify('+1 year');
    	self::assertEquals(1234567890 + 365 * 86400, $this->dateTime->format('U'), '+1 year');
    }
    
 	public function testSubtractYear() {
    	$this->dateTime->modify('-1 year');
    	self::assertEquals(1234567890 - 366 * 86400, $this->dateTime->format('U'), '-1 year');
    }
    
    public function testMidnight() {
    	$this->dateTime->modify('midnight');
    	self::assertEquals(strtotime('2009-02-13 00:00:00GMT'), $this->dateTime->format('U'), 'midnight');
    }
	
    public function testToday() {
    	$this->dateTime->modify('today');
    	self::assertEquals(strtotime('2009-02-13 00:00:00GMT'), $this->dateTime->format('U'), 'today');
    }
    
	public function testNoon() {
    	$this->dateTime->modify('noon');
    	self::assertEquals(strtotime('2009-02-13 12:00:00GMT'), $this->dateTime->format('U'), 'noon');
    }
    
    public function testYesterday() {
    	$this->dateTime->modify('yesterday');
    	self::assertEquals(1234567890 - 86400, $this->dateTime->format('U'), 'yesterday');
    }
    
	public function testTomorrow() {
    	$this->dateTime->modify('tomorrow');
    	self::assertEquals(1234567890 + 86400, $this->dateTime->format('U'), 'tomorrow');
    }
    
	public function testFirstDayOfThisMonth() {
    	$this->dateTime->modify('first day of this month');
    	self::assertEquals(strtotime('2009-02-01 00:00:00GMT'), $this->dateTime->format('U'), 'first day of this month');
    }
    
	public function testLastDayOfThisMonth() {
    	$this->dateTime->modify('last day of this month');
    	self::assertEquals(strtotime('2009-02-28 00:00:00GMT'), $this->dateTime->format('U'), 'last day of this month');
    }
    
    
    
}