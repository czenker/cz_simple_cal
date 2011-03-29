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
			
//			array('filterCategories', array(), null),
//			array('filterCategories', 'KILL ALL HUMANS', null),
//			array('filterCategories', 0, array(0)),
//			array('filterCategories', 1, array(1)),
//			array('filterCategories', '1', array(1)),
//			array('filterCategories', '1,2', array(1,2)),
//			array('filterCategories', '1, 2,,', array(1,2)),
//			array('filterCategories', array(1,'2'), array(1,2)),
//			array('filterCategories', array(1,2,''), array(1,2)),
//			array('filterCategories', array(1,2,'KILL ALL HUMANS'), array(1,2)),
			
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
	
	/**
	 * just a very simple basic test
	 */
	public function testCleanSettingsFieldsForFiltersBasic() {
		$ret = $this->repository->cleanSettings(array('filter' => array('foo' => 'bar')));
		
		$this->assertSame(array(
			'foo' => array('value' => array('bar'))
		), $ret['filter']);
	}
	
	/**
	 * test that numbers given are converted to integers
	 */
	public function testCleanSettingsFieldsForFiltersCheckNumbersAreConvertedToIntegers() {
		$ret = $this->repository->cleanSettings(array('filter' => array('foo' => '42')));
		
		$this->assertSame(array(
			'foo' => array('value' => array(42))
		), $ret['filter']);
	}
	
	/**
	 * test that multiple given values are converted into an array
	 */
	public function testCleanSettingsFieldsForFiltersCheckMultipleValuesAreConvertedToAnArray() {
		$ret = $this->repository->cleanSettings(array('filter' => array('foo' => 'bar,baz,42')));
		
		$this->assertSame(array(
			'foo' => array('value' => array('bar', 'baz', 42))
		), $ret['filter']);
	}
	
	/**
	 * test that selecting the fields to filter recursive over multiple tables
	 */
	public function testCleanSettingsFieldsForFiltersCheckNestingOfFields() {
		$ret = $this->repository->cleanSettings(array('filter' => array(
			'foo' => array(
				'baz' => 'bar',
				'bar' => array(
					'superfoo' => 'someothervalue',
					'foo' => array(
						'value' => 'foobar'
					),
				),
			),
		)));
		$this->assertArrayHasKey('foo.baz', $ret['filter'], 'one level down');
		$this->assertArrayHasKey('foo.bar.superfoo', $ret['filter'], 'two levels down');
		$this->assertArrayNotHasKey('foo.bar.foo.value', $ret['filter'], 'keywords are not converted');
	}
	
	
	public function testCleanSettingsFieldsForFiltersCheckAdditionalInstructions() {
		$ret = $this->repository->cleanSettings(array('filter' => array(
			'foo' => array(
				'value' => 'bar',
				'negate' => '1',
			),
		)));
		
		$this->assertSame(array(
			'foo' => array('value' => array('bar'), 'negate' => '1')
		), $ret['filter']);
		
	}
	
	public function testCleanSettingsFieldsForFiltersCheckValuesFromTyposcript() {
		$config = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray(array(
			'foo' => 'bar',
			'foo.' => array(
				'negate' => '1',
			)
		));
		
		$ret = $this->repository->cleanSettings(array('filter' => $config));
		
		$this->assertSame(array(
			'foo' => array('negate' => '1', 'value' => array('bar'))
		), $ret['filter']);
	}
	
	/**
	 * @see http://forge.typo3.org/issues/14093
	 */
	public function testCleanSettingsFieldsForFiltersCheckFlexformOverridesDefault() {
		$config = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray(array(
			'foo' => '1,2,3',
			'foo.' => array(
				'value' => '42',
				'negate' => '1',
			)
		));
		
		$ret = $this->repository->cleanSettings(array('filter' => $config));
		
		$this->assertSame(
			array(1, 2, 3),
			$ret['filter']['foo']['value'],
			'values where correctly overriden'
		);
		$this->assertArrayNotHasKey('_typoScriptNodeValue', $ret['filter']['foo'], '_typoScriptNodeValue was unset');
	}
	
	
	
}

require_once(t3lib_extMgm::extPath('cz_simple_cal').'/Classes/Domain/Repository/EventIndexRepository.php');

class Tx_CzSimpleCal_Domain_Repository_EventIndexRepositoryMock extends Tx_CzSimpleCal_Domain_Repository_EventIndexRepository {
	public function cleanSettings($settings) {
		return parent::cleanSettings($settings);
	}
}