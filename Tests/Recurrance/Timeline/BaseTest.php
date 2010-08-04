<?php 
require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../Classes/Recurrance/Timeline/Base.php';
 
/**
 * testing the features of Tx_CzSimpleCal_Recurrance_Timeline_Base
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class RecurranceTimlineBaseTest extends PHPUnit_Framework_TestCase {
	
	
	protected $timeline = null;
	
	public function setUp() {
		$this->timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
	}
	
	public function testBasic() {
		$this->timeline->add(array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end' => strtotime('2009-02-13 23:31:31GMT')
		));
		
		self::assertGreaterThanOrEqual(1, count($this->timeline->toArray()), 'timespans can be added');
	}
	
	/**
	 * test if the class implements the iterator interface
	 * @depends testBasic
	 */
	public function testIterator() {
		$first = array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end' => strtotime('2009-02-13 23:31:31GMT')
		);
		
		$second = array(
			'start' => strtotime('2009-02-13 23:31:32GMT'),
			'end' => strtotime('2009-02-13 23:31:33GMT')
		);
		
		$this->timeline->add($first)->add($second);
		
		self::assertTrue($this->timeline instanceof Iterator, 'the class implements the Iterator-Interface');
		
		self::assertEquals($first, $this->timeline->current(), 'calling current() for the first time returns the first element.');
		self::assertEquals($first, $this->timeline->current(), 'calling current() for the second time returns the first element again.');
		self::assertEquals($first['start'], $this->timeline->key(), 'calling key() returns the key of the first element.');
		self::assertEquals($second, $this->timeline->next(), 'calling next() for the first time returns the second element again.');
		self::assertEquals($second, $this->timeline->current(), 'calling current() after next() returns the second element again.');
		self::assertSame(false, $this->timeline->next(), 'calling next() after the end of the array returns false.');
		
		$this->timeline->rewind();
		self::assertEquals($first, $this->timeline->current(), 'calling reset() resets the pointer to the first element.');
	}
	
	/**
	 * test if the class implements the ArrayAccess interface
	 * @depends testBasic
	 */
	public function testArrayAccess() {
		$first = array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end' => strtotime('2009-02-13 23:31:31GMT')
		);
		
		$second = array(
			'start' => strtotime('2009-02-13 23:31:32GMT'),
			'end' => strtotime('2009-02-13 23:31:33GMT')
		);
		
		$this->timeline->add($first);
		
		self::assertTrue($this->timeline instanceof ArrayAccess, 'the class implements the ArrayAccess-Interface');
		
		try {
			$this->timeline[] = $second;
			self::fail('setting of values is forbidden.');
		}
		catch (BadMethodCallException $e) {
			self::assertTrue(true, 'setting of values is forbidden.');
		}
		
		$this->timeline->add($second);
		
		
		
		self::assertEquals($first, $this->timeline[$first['start']], 'getting of values works.');
		
		isset($this->timeline[$first['start']]);
		self::assertTrue(isset($this->timeline[$first['start']]), 'isset() returns true if offset exists.');
		self::assertFalse(isset($this->timeline[$first['start']-1]), 'isset() returns false if offset does not exist.');
		
		unset($this->timeline[$first['start']]);
		isset($this->timeline[$first['start']]);
		self::assertFalse(isset($this->timeline[$first['start']]), 'unset() unsets the value');
		
	}
	
	/**
	 * test that all added elements are always ordered by their start date
	 * 
	 * @depends testIterator
	 */
	public function testOrder() {
		
		$early = array(
			'start' => strtotime('2009-02-13 23:31:30GMT'),
			'end' => strtotime('2009-02-13 23:31:31GMT')
		);
		
		$late = array(
			'start' => strtotime('2009-02-13 23:31:32GMT'),
			'end' => strtotime('2009-02-13 23:31:33GMT')
		);
		
		$this->timeline->add($early)->add($late);
		self::assertEquals($early, $this->timeline->current(), 'when adding events in the correct order they are ordered ascending.');
		
		
		$this->timeline = new Tx_CzSimpleCal_Recurrance_Timeline_Base();
		$this->timeline->add($late)->add($early);
		self::assertEquals($early, $this->timeline->current(), 'when adding events in the wrong order they are ordered ascending anyways.');
	}
	
	
}