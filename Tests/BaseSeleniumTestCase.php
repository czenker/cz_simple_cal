<?php

if(t3lib_extMgm::isLoaded('selenium')) {
	
	require_once t3lib_extMgm::extPath('selenium') . 'class.tx_selenium_testcase.php';
	
	abstract class Tx_CzSimpleCal_Test_BaseSeleniumTestCase extends tx_selenium_testcase {
		
		protected $browserUrl;
		protected $browser;
		
		public function setUp() {
			if(is_null($this->browserUrl)) {
				$this->browserUrl = $this->guessBrowserUrl();
			}
			$this->initializeSelenium(
				is_null($this->browser) ? "*firefox" : $this->browser,
				$this->browserUrl
			);
		}
		
		public function tearDown() {
			try {
	           $this->selenium->stop();
	        } catch (Testing_Selenium_Exception $e) {
	            echo $e;
	        }
		}
		
		protected function guessBrowserUrl() {
			$url = t3lib_div::getThisUrl();
			$pos = strpos($url, 'typo3/');
			if($pos === false) {
				throw new RuntimeException('Could not determine the url for the frontend.');
			}
			return 'http://'.substr($url, 0, $pos);
		}
		
		public function assertTextPresent($pattern, $message = null) {
			$this->assertTrue(
				$this->selenium->isTextPresent($pattern),
				is_null($message) ? $message : sprintf('"assert text present: %s"', $pattern)
			);
		}
		
		public function assertTextNotPresent($pattern, $message = null) {
			$this->assertFalse(
				$this->selenium->isTextPresent($pattern),
				is_null($message) ? $message : sprintf('"assert text is not present: %s"', $pattern)
			);
		}
		
		public function assertElementPresent($locator, $message = null) {
			$this->assertTrue(
				$this->selenium->isElementPresent($locator),
				is_null($message) ? $message : sprintf('"assert element present: %s"', $locator)
			);
		}
		
		public function assertElementNotPresent($locator, $message = null) {
			$this->assertFalse(
				$this->selenium->isElementPresent($locator),
				is_null($message) ? $message : sprintf('"assert element is not present: %s"', $locator)
			);
		}
	}
} else {
	abstract class Tx_CzSimpleCal_Test_BaseSeleniumTestCase extends tx_phpunit_testcase {
		
		public function setUp() {
			$this->markTestSkipped('You don\'t have the extension "selenium" enabled, so this test will be skipped.');
		}
	}
}