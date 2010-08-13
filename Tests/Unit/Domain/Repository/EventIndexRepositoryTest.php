<?php

/**
 * testing the Domain_Repository_EventIndex class
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Domain_Repository_EventIndexTest extends tx_phpunit_testcase {
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventIndexRepositoryMock
	 */
	protected $repository;
	
	public function setUp() {
		t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
		$this->repository = new Tx_CzSimpleCal_Domain_Repository_EventIndexRepositoryMock();
	}
	
	/**
	 * @dataProvider provideDataForCleanSettingsFields
	 */
	public function testCleanSettingsFields($field, $value, $assumed) {
		$ret = $this->repository->cleanSettings(array($field => $value));
		
		$this->assertSame($assumed, $ret[$field]);
	}
	
	public function provideDataForCleanSettingsFields() {
		$data = array(
			array('startDate', 1234567890, 1234567890),
			array('startDate', '1234567890', 1234567890),
			array('startDate', '', null),
			array('startDate', '42 AND foo=bar', null), //XSS test
			
			array('endDate', 1234567890, 1234567890),
			array('endDate', '1234567890', 1234567890),
			array('endDate', '', null),
			array('endDate', '42 AND foo=bar', null), //XSS test
			
			array('maxEvents', 10, 10),
			array('maxEvents', '10', 10),
			array('maxEvents', null, null),
			array('maxEvents', 0, null),
			array('maxEvents', -42, null),
			array('maxEvents', '42 AND foo=bar', null), //XSS test
			
			array('order', 'asc', 'asc'),
			array('order', 'desc', 'desc'),
			array('order', 'foobar', null),
			array('order', ';DELETE table', null), //XSS test
			
			array('orderBy', 'start', 'start'),
			array('orderBy', 'end', 'end'),
			array('orderBy', 'foobar', 'foobar'),
			array('orderBy', '', null),
			array('orderBy', 'foo; DELETE table', null), //XSS test
			
			array('filterCategories', array(), null),
			array('filterCategories', 'KILL ALL HUMANS', null),
			array('filterCategories', 0, array(0)),
			array('filterCategories', 1, array(1)),
			array('filterCategories', '1', array(1)),
			array('filterCategories', '1,2', array(1,2)),
			array('filterCategories', '1, 2,,', array(1,2)),
			array('filterCategories', array(1,'2'), array(1,2)),
			array('filterCategories', array(1,2,''), array(1,2)),
			array('filterCategories', array(1,2,'KILL ALL HUMANS'), array(1,2)),
			
			array('groupBy', 'day', 'day'),
			array('groupBy', 'foobar', 'foobar'),
			array('groupBy', '', null),
			array('groupBy', 'foo; DELETE table', null), //XSS test
			
			array('includeStartedEvents', true, true),
			array('includeStartedEvents', '1', true),
			array('includeStartedEvents', 1, true),
			array('includeStartedEvents', false, false),
			array('includeStartedEvents', '0', false),
			array('includeStartedEvents', 0, false),
			array('includeStartedEvents', 'KILL ALL HUMANS', false),
			array('includeStartedEvents', null, false),
			
			array('excludeOverlongEvents', true, true),
			array('excludeOverlongEvents', '1', true),
			array('excludeOverlongEvents', 1, true),
			array('excludeOverlongEvents', false, false),
			array('excludeOverlongEvents', '0', false),
			array('excludeOverlongEvents', 0, false),
			array('excludeOverlongEvents', 'KILL ALL HUMANS', false),
			array('excludeOverlongEvents', null, false),
		);
		
		$label = $data;
		array_walk($label, array($this, 'nameDataProviderForCleanSettingsFields'));
		
		return array_combine($label, $data);
	}
	
	protected function nameDataProviderForCleanSettingsFields(&$value, $key) {
		$value = sprintf(
			'%s set to %s:%s returns %s', 
			$value[0], 
			gettype($value[1]), 
			htmlspecialchars(print_r($value[1], true)), 
			htmlspecialchars(print_r($value[2], true))
		);
	}
}

require_once(t3lib_extMgm::extPath('cz_simple_cal').'/Classes/Domain/Repository/EventIndexRepository.php');

class Tx_CzSimpleCal_Domain_Repository_EventIndexRepositoryMock extends Tx_CzSimpleCal_Domain_Repository_EventIndexRepository {
	public function cleanSettings($settings) {
		return parent::cleanSettings($settings);
	}
}