<?php

/**
 * holds multiple EventIndices for the same Event
 *
 * to keep it lightweight, when creating EventIndices from Events
 * they are not instanciated as objects, but are represented by an array.
 *
 * This class manages these arrays and takes care of a valid syntax.
 *
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Domain_Collection_EventIndex implements Iterator, ArrayAccess {

	/**
	 * the EventIndices as array
	 * @var array
	 */
	protected $eventIndices = array();

	/**
	 * the id of the Event this collection belongs to
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $event = null;

	/**
	 * add an EventIndex to the collection
	 *
	 * @param $data
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function add($data) {
		try {
			$this->isDataValid($data);
			$this->eventIndices[] = $data;
		}
		catch (UnexpectedValueException $e) {
			throw new UnexpectedValueException(sprintf('The given data is not valid for %s: %s', get_class($this), $e->getMessage()));
		}
		return $this;
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

		$data['start'] = intval($data['start']);
		$data['end']  = intval($data['end']);

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
	 * set the id of the Event this collection belongs to
	 * 
	 * @param $id
	 * @return Tx_CzSimpleCal_Domain_Collection_EventIndex
	 */
	public function setEvent($event) {
		$this->event = $event;
		return $this;
	}

	
	
	
	/**
	 * returns the data as an array
	 * (for debugging only - this class already behaves as if it was an array)
	 * 
	 * @internal
	 * @return array
	 */
	public function toArray() {
		return $this->eventIndices;
	}
	
	/**
	 * add the model id to an EventIndex
	 * 
	 * @param array $array
	 * @return array
	 */
	protected function addEvent($array){
		$array['event'] = $this->event;
		$array['pid'] = $this->event->getPid();
		return $array;
	}
	
	/* implement Iterator */
	
	public function rewind() {
		reset($this->eventIndices);
	}

	public function current() {
		return $this->addEvent(current($this->eventIndices));
	}

	public function key() {
		return key($this->eventIndices);
	}

	public function next() {
		return $this->addEvent(next($this->eventIndices));
	}

	public function valid() {
		return NULL !== key($this->eventIndices);
	}
	
	/* implement ArrayAccess */
	
	/**
	 * @ignore
	 */
    public function offsetSet($offset, $value) {
        throw new BadMethodCallException(sprintf('%s allows setting of values only through the add($data) - method.', get_class($this)));
    }
    public function offsetExists($offset) {
        return array_key_exists($offset, $this->eventIndices);
    }
    
    /**
     * @ignore
     */
    public function offsetUnset($offset) {
        throw new BadMethodCallException(sprintf('%s does not allow unsetting of values.', get_class($this)));
    }
    public function offsetGet($offset) {
        return $this->addEvent($this->eventIndices[$offset]);
    }

}