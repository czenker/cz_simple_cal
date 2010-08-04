<?php

/**
 * a class representing a timeline of events
 * 
 * so that's basically a collection of events with a start and an end, that are sorted by their start dates
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Timeline_Base implements Iterator {

	/**
	 * holds all timespans
	 * 
	 * @var array
	 */
	protected $data = array();
	
	protected $sortNeeded = false;
	protected $lastValue = 0;
	
	protected $nextAsCurrent = false;
	
	
	
	/**
	 * add an EventIndex to the collection
	 *
	 * @param $data
	 * @return Tx_CzSimpleCal_Recurrance_Timeline_Base
	 */
	public function add($data) {
		try {
			$data = $this->cleanData($data);
			$this->isDataValid($data);
			$this->data[$data['start']] = $data;
			if($data['start'] < $this->lastValue) {
				$this->sortNeeded = true;
			}
			$this->lastValue = $data['start'];
		}
		catch (UnexpectedValueException $e) {
			throw new UnexpectedValueException(sprintf('The given data is not valid for %s: %s', get_class($this), $e->getMessage()));
		}
		return $this;
	}

	
	protected function cleanData($data) {
		$data['start'] = intval($data['start']);
		$data['end'] = intval($data['end']);
		return $data;
	}
	/**
	 * check if the given data is valid
	 *
	 * @param $data
	 * @throws UnexpectedValueException
	 * @return true
	 */
	protected function isDataValid($data) {
		if(!array_key_exists('start', $data)) {
			throw new UnexpectedValueException('"start" is required.');
		}
		if(!array_key_exists('end', $data)) {
			throw new UnexpectedValueException('"end" is required.');
		}
		
		if($data['start'] == 0) {
			throw new UnexpectedValueException('"start" should not be "0".');
		}
		if($data['end'] == 0) {
			throw new UnexpectedValueException('"end" should not be "0".');
		}

		if($data['start'] > $data['end']) {
			throw new UnexpectedValueException(sprintf('"start" should not be later than "end". (%d, %d)', $data['start'], $data['end']));
		}

		return true;
	}
	
	/**
	 * initializes output by sorting the array
	 * 
	 * @return null
	 */
	protected function initOutput() {
		if(!$this->sortNeeded) {
			return;
		}
		ksort($this->data);
		$this->sortNeeded = false;
	}

	/**
	 * returns the data as an array
	 * (for debugging only - this class already behaves as if it was an array)
	 * 
	 * @internal
	 * @return array
	 */
	public function toArray() {
		return $this->data;
	}
	
	/**
	 * check if this has data
	 * 
	 * @return boolean
	 */
	public function hasData() {
		return count($this->data) > 0;
	}

	/* implement Iterator */
	
	public function rewind() {
		$this->initOutput();
		reset($this->data);
	}

	public function current() {
		$this->initOutput();
		return current($this->data);
	}

	public function key() {
		$this->initOutput();
		return key($this->data);
	}

	public function next() {
		$this->initOutput();
		if($this->nextAsCurrent) {
			$this->nextAsCurrent = false;
			return current($this->data);
		}
		return next($this->data);
	}

	public function valid() {
		$this->initOutput();
		return NULL !== key($this->data);
	}
	
	
	public function unsetCurrent() {
		unset($this->data[key($this->data)]);
		$this->nextAsCurrent = true;
	}
	
}