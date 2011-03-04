<?php 

/**
 * Sampletest that do some more tests
 */
class Tx_CzSimpleCalTests_Selenium_Test extends Tx_CzSimpleCal_Test_BaseSeleniumTestCase {
	
	protected function openPageAlias($alias, $parameters = null) {
		$this->selenium->open('index.php?id='.$alias.$parameters);
		$this->selenium->waitForPageToLoad(10000);
		
		//check that page was really found
		$this->assertNotContains('home',$this->selenium->getTitle(), sprintf('Page with alias "%s" does exist.', $alias));
		
	}
	
	public function testActionList() {
		$this->openPageAlias('action-list');
		
		$this->assertElementPresent('css=div.vcalendar-list', 'default view is list-view');
		
		$this->assertElementPresent('link=Bongo Day', 'allday event is present');
		$this->assertElementPresent('link=Playing Golf', 'event with only start is present');
		$this->assertElementPresent('link=Going fishing', 'event with start and end on different days is present');
		$this->assertElementPresent('link=Jogging with friends', 'event with start and end on same day is present');
		
		$this->assertElementNotPresent('link=Hidden event', 'hidden event is not present');
		$this->assertElementNotPresent('link=Deleted event', 'deleted event is not present');
		
		//default for startDate
		$this->assertGreaterThan(strtotime('2010-01-01 00:00:00UTC'), $this->getDateOfFirstEvent(), 'default for startDate');
		//default for endDate
		$this->assertLessThan(strtotime('2010-01-07 23:59:59UTC'), $this->getDateOfLastEvent(), 'default for endDate');
		//default for excludeOverlongEvents
		$this->assertElementPresent('link=overlong event', 'default for excludeOverlongEvents is false');
		//default for includeStartedEvents
		$this->assertElementNotPresent('link=already started event', 'default for includeStartedEvents is false');
		
		

		// check setting: startDate
		$this->openPageAlias('action-list-startdate');
		$this->assertElementNotPresent('link=Going fishing', 'testing setting startDate');
		
		
		
		// check setting: endDate
		$this->openPageAlias('action-list-enddate');
		$this->assertElementNotPresent('link=Playing Golf', 'testing setting endDate');
		
		
		
		// check setting: maxEvents
		$this->openPageAlias('action-list-maxevents');
		$this->assertEquals(2, $this->selenium->getXpathCount('//div[contains(@class, "vevent")]'), 'testing setting maxEvents');
		
		
		
		//check setting: orderBy
		$this->openPageAlias('action-list-orderby');
		$this->assertSame('overlong event', $this->selenium->getText('//div[@class="vevent"][last()]//h5'), 'testing setting orderBy');
		
		
		
		//check setting: order
		$this->openPageAlias('action-list-order');
		$this->assertSame('Wed, January 6, 2010', $this->selenium->getText('//div[contains(@class, "vcalendar-list")]//h4'), 'testing setting order');
		
		
		
		//check setting: filter.categories
		$this->openPageAlias('action-list-filtercategories');
		$this->assertEquals(2, $this->selenium->getXpathCount('//*[contains(@class, "vevent")]'), 'testing setting filterCategories');
		
		
		
		// check setting: excludeOverlongEvents
		$this->openPageAlias('action-list-excludeoverlong');
		$this->assertElementNotPresent('link=overlong event', 'testing setting excludeOverlongEvents');
		
		
		
		// check setting: includeStartedEvents
		$this->openPageAlias('action-list-includestartedevents');
		$this->assertElementPresent('link=already started event', 'testing setting includeStartedEvents');
		
		
		
		//check setting: getDate
		$this->openPageAlias('action-list-getdate');
		$this->assertSame('Fri, July 9, 2010', $this->selenium->getText('//div[contains(@class, "vcalendar-list")]//h4'), 'testing setting getDate (start at correct date)');
		
		
		
		//check setting: getPostAllowed
		$this->openPageAlias('action-list-getpostallowed-off', '&tx_czsimplecal_pi1[getDate]=2010-07-01');
		$firstDate = $this->getDateOfFirstEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('midnight');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('+1 week');
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'if getPostAllowed is empty, no config is overridden (#1)');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'if getPostAllowed is empty, no config is overridden (#2)');
		
		//override getDate
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[getDate]=2010-07-01');
		$firstDate = $this->getDateOfFirstEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-01');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-08');
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'getDate can be overridden if enabled (#1)');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'getDate can be overridden if enabled (#2)');
		
		//override startDate
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[startDate]=2010-07-01');
		$firstDate = $this->getDateOfFirstEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-01');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-08');
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'startDate can be overridden if enabled (#1)');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'startDate can be overridden if enabled (#2)');
		
		//override endDate
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[startDate]=2010-07-01&tx_czsimplecal_pi1[endDate]=2010-07-08');
		$firstDate = $this->getDateOfLastEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-01');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('2010-07-08');
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'endDate can be overridden if enabled (#1)');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'endDate can be overridden if enabled (#2)');
		
		//override maxEvents
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[maxEvents]=2');
		$this->assertEquals(2, $this->selenium->getXpathCount('//*[contains(@class, "vevent")]'), 'endDate can be overridden if enabled');
		
		//override orderBy
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[orderBy]=endDate&tx_czsimplecal_pi1[startDate]=2010-01-01 00:00:00&tx_czsimplecal_pi1[endDate]=2010-01-07 23:59:59');
		$this->assertSame('overlong event', $this->selenium->getText('//div[@class="vevent"][last()]//h5'), 'orderBy can be overridden if enabled');
		
		//override order
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[order]=desc&tx_czsimplecal_pi1[startDate]=2010-01-01 00:00:00&tx_czsimplecal_pi1[endDate]=2010-01-07 23:59:59');
		$this->assertSame('Wed, January 6, 2010', $this->selenium->getText('//div[contains(@class, "vcalendar-list")]//h4'), 'order can be overridden if enabled');
				
		//override excludeOverlongEvents
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[excludeOverlongEvents]=1&tx_czsimplecal_pi1[startDate]=2010-01-01 00:00:00&tx_czsimplecal_pi1[endDate]=2010-01-07 23:59:59');
		$this->assertElementNotPresent('//h5[. = "overlong event"]', 'excludeOverlongEvents can be overridden if enabled');
		
		//override includeStartedEvents
		$this->openPageAlias('action-list-getpostallowed', '&tx_czsimplecal_pi1[includeStartedEvents]=1&tx_czsimplecal_pi1[startDate]=2010-01-01 00:00:00&tx_czsimplecal_pi1[endDate]=2010-01-07 23:59:59');
		$this->assertElementPresent('//h5[. = "already started event"]', 'includeStartedEvents can be overridden if enabled');
		
	}
	
	
	/**
	 * test the day view
	 */
	public function testActionDay() {
		$this->openPageAlias('action-day', '&tx_czsimplecal_pi1[getDate]=2010-01-01');
		
		$this->assertElementPresent('css=div.vcalendar-day', 'day-view is shown');
		$this->assertElementPresent('//h2[. = "Events on January  1, 2010"]', 'heading is shown');
		$this->assertEquals(1, $this->selenium->getXpathCount('//*[contains(@class, "vevent")]'), 'one event is shown');
		
		// no further tests as all other settings were tested in the list-action
	}
	
	/**
	 * test the week view
	 */
	public function testActionWeek() {
		$this->openPageAlias('action-week');
		
		$this->assertElementPresent('css=div.vcalendar-list', 'week-view is shown');
		
		$firstDate = $this->getDateOfFirstEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('-1 week');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('+1 week');
		
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'first event is not older than one week');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'first event is at max one week in the future');
	}
	
	/**
	 * test the next view
	 */
	public function testActionNext() {
		$this->openPageAlias('action-next');
		
		$this->assertElementPresent('css=div.vcalendar-next', 'next-view is shown');
		$this->assertEquals(1, $this->selenium->getXpathCount('//*[contains(@class, "vevent")]'), 'only one event is shown');
		
		$firstDate = $this->getDateOfFirstEvent();
		$minDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('now');
		$maxDate = Tx_CzSimpleCal_Utility_StrToTime::strtotime('+2 days');
		
		$this->assertGreaterThanOrEqual($minDate, $firstDate, 'event starts later than now');
		$this->assertLessThanOrEqual($maxDate, $firstDate, 'event start before the next two days');
		
		// no further tests as all other settings were tested in the list-action
	}
	
	public function testActionShow() {
		$this->openPageAlias('action-list');
		
		$this->selenium->click('css=a.url');
		$this->selenium->waitForPageToLoad(10000);
		$this->assertElementPresent('css=div.vcalendar-event', 'show-view is shown when clicking on an event in the list');
	}
	
	
	
	public function testActionMinimonth() {
		
		$this->openPageAlias('action-minimonth');
		
		$this->assertElementPresent('css=div.vcalendar-minimonth', 'default view is minimonth-view');
		$this->assertElementPresent('css=table', 'some table is shown');
		
		
		// check display and semantics
		foreach(array(
			'2010-02-01', // 28 days starting Monday
			'2011-02-01', // 28 days starting Tuesday
			'2017-02-01', // 28 days starting Wednesday
			'2018-02-01', // 28 days starting Thursday
			'2013-02-01', // 28 days starting Friday
			'2014-02-01', // 28 days starting Saturday
			'2015-02-01', // 28 days starting Sunday
		
			'2016-02-01', // 29 days starting Monday
			'2012-02-01', // 29 days starting Wednesday
			'2020-02-01', // 29 days starting Saturday
			
			'2010-11-01', // 30 days starting Monday
			'2010-06-01', // 30 days starting Tuesday
			'2010-09-01', // 30 days starting Wednesday
			'2010-04-01', // 30 days starting Thursday
			'2011-04-01', // 30 days starting Friday
			'2012-09-01', // 30 days starting Saturday
			'2012-04-01', // 30 days starting Sunday
		
			'2010-03-01', // 31 days starting Monday
			'2011-03-01', // 31 days starting Tuesday
			'2010-12-01', // 31 days starting Wednesday
			'2010-07-01', // 31 days starting Thursday
			'2010-01-01', // 31 days starting Friday
			'2010-05-01', // 31 days starting Saturday
			'2010-08-01', // 31 days starting Sunday
			
		) as $month){
			
			$this->openPageAlias('action-minimonth', '&tx_czsimplecal_pi1[getDate]='.$month);
			
			$this->assertElementPresent('css=div.vcalendar-minimonth', $month.': default view is minimonth-view');
			$this->assertElementPresent('css=table', $month.': some table is shown');
			
			//check for the naming of headers
			// date is used to ensure english localisation
			$this->assertContains(date('F Y', strtotime($month)) , $this->selenium->getText('//table//thead//tr[1]'), $month.': header label is correct and in english');
			
			$headerDays = $this->selenium->getText('//table//thead//tr[2]');
			$this->assertStringStartsWith('Mon', $headerDays, $month.': monday is the first day of the week');
			$this->assertSame('Mon Tue Wed Thu Fri Sat Sun', $headerDays, $month.': a value for each day of the week is shown.');
			
			//check for the correct week and day count
			$displayedWeeks = $this->selenium->getXpathCount('//table//tbody//tr');
			$this->assertGreaterThan(3, $displayedWeeks, $month.': at least 4 weeks are shown.');
			$this->assertLessThan(7, $displayedWeeks, $month.': at most 6 weeks are shown.');
			
			$this->assertEquals($displayedWeeks, $this->selenium->getXPathCount('//table//tbody//tr/td[1][contains(@class, "cal-minimonth-woy")]'), $month.': every week has a week count');
			$this->assertEquals(7 * $displayedWeeks, $this->selenium->getXPathCount('//table//tbody//td[contains(@class, "cal-minimonth-day")]'), $month.': every week is filled with 7 days.');
			
			//check setting of off-days and that there is at least one day of the month in each row
			$daysOfMonthInFirstLine = $this->selenium->getXPathCount('//table//tbody/tr[1]/td[contains(@class, "cal-minimonth-day")][. < 8]'); //select all <td>'s having a lower value than 08
			$this->assertGreaterThan(0, $daysOfMonthInFirstLine, $month.': at least one day of this month is shown in first row');
			$this->assertEquals(7-$daysOfMonthInFirstLine, $this->selenium->getXPathCount('//table//tbody/tr[1]//td[contains(@class, "cal-minimonth-dayoff")]'), $month.': all days not of this month are marked with a class in first week.');
			
			$daysOfMonthInLastLine = $this->selenium->getXPathCount('//table//tbody/tr[last()]/td[contains(@class, "cal-minimonth-day")][. > 20]'); //select all <td>'s having a higher value than 20
			$this->assertGreaterThan(0, $daysOfMonthInLastLine, $month.': at least one day of this month is shown in last row');
			
			$this->assertEquals(7-$daysOfMonthInLastLine, $this->selenium->getXPathCount('//table//tbody/tr[last()]//td[contains(@class, "cal-minimonth-dayoff")]'), $month.': all days not of this month are marked with a class in last week.');
			
		}
		
		//check that correct elements are linked
		
		$this->openPageAlias('action-minimonth', '&tx_czsimplecal_pi1[getDate]=2010-01-01');
		
		// we'll use this week to not confuse with links to week
		$this->assertElementPresent('link=18', 'monday is linked');
		$this->assertEquals('2 events', $this->selenium->getAttribute('//td//a[. = "18"]/@title'), 'multiple events use the plural in title');
		$this->assertElementNotPresent('link=19', 'tuesday is not linked');
		$this->assertEquals('No events', $this->selenium->getAttribute('//td//span[. = "19"]/@title'), 'no events have correct title');
		$this->assertElementPresent('link=20', 'wednesday is linked');
		$this->assertEquals('1 event', $this->selenium->getAttribute('//td//a[. = "20"]/@title'), 'single event uses the singular in title');
		$this->assertElementNotPresent('link=21', 'thursday is not linked');
		$this->assertElementPresent('link=22', 'friday is linked');
		$this->assertEquals('1 event', $this->selenium->getAttribute('//td//a[. = "22"]/@title'), 'correct event count on friday');
		$this->assertElementPresent('link=23', 'saturday is linked');
		$this->assertEquals('1 event', $this->selenium->getAttribute('//td//a[. = "23"]/@title'), 'correct event count on saturday');
		$this->assertElementNotPresent('link=24', 'sunday is not linked');
		
	}
	
	/**
	 * do some tests on the default templates
	 */
	public function testDefaultTemplate() {
		$this->openPageAlias('action-list');
		
		// check for the basic hcard format in list to be correct
		$this->assertEquals('http://microformats.org/profile/hcalendar', $this->selenium->getAttribute('//link[@rel="profile"]/@href'), 'hCalendar profile is loaded in LIST view');
		$this->assertElementPresent('//div[contains(@class, "vevent")]', 'at least one vevent marked as such is shown');
		
		$this->assertRegExp(
			'/^\d{4}\-\d{2}\-\d{2}T\d{2}:\d{2}[+\-]\d{4}$/',
			$this->selenium->getAttribute('//div[contains(@class, "vevent")]//*[contains(@class, "dtstart")]/@title'),
			'"dtstart" is a timestamp in an acceptable format'
		);
		
		$this->assertElementPresent('//div[contains(@class, "vevent")]//*[contains(@class, "summary")]', 'a "summary" is present');
		$this->assertNotEquals(
			'',
			$this->selenium->getText('//div[contains(@class, "vevent")]//*[contains(@class, "summary")]'),
			'"summary" is not empty'
		);
		
		$this->assertElementPresent('//div[contains(@class, "vevent")]//a[contains(@class, "url")]', 'an "url" is present');
		
		$this->selenium->click('//div[contains(@class, "vevent")]//a[contains(@class, "url")]');
		$this->selenium->waitForPageToLoad(10000);
		
		$this->assertElementPresent('//div[contains(@class, "vcalendar-event")]', 'the opened view shows an event in the SHOW view');
		
		$this->assertEquals('http://microformats.org/profile/hcalendar', $this->selenium->getAttribute('//link[@rel="profile"]/@href'), 'hCalendar profile is loaded in SHOW view');
		$this->assertElementPresent('//div[contains(@class, "vevent")]', 'one vevent marked as such is shown');
		
		$this->assertRegExp(
			'/^\d{4}\-\d{2}\-\d{2}T\d{2}:\d{2}[+\-]\d{4}$/',
			$this->selenium->getAttribute('//div[contains(@class, "vevent")]//*[contains(@class, "dtstart")]/@title'),
			'"dtstart" is a timestamp in an acceptable format in SHOW view'
		);
		
		$this->assertElementPresent('//div[contains(@class, "vevent")]//*[contains(@class, "summary")]', 'a "summary" is present in SHOW view');
		$this->assertNotEquals(
			'',
			$this->selenium->getText('//div[contains(@class, "vevent")]//*[contains(@class, "summary")]'),
			'"summary" is not empty in SHOW view'
		);
	}
	
	/**
	 * get a timestamp of the first shown event
	 */
	protected function getDateOfFirstEvent() {
		return strtotime($this->selenium->getAttribute('//div[@class="dtstart"]@title'));
	}
	
	/**
	 * get a timestamp of the last shown event
	 */
	protected function getDateOfLastEvent() {
		return strtotime($this->selenium->getAttribute('//div[@class="vevent"][last()]/div[@class="dtstart"]@title'));
	}
	
	
}