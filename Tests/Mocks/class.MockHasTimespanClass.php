<?php 

require_once t3lib_extMgm::extPath('cz_simple_cal').'Classes/Domain/Interface/HasTimespan.php';

class MockHasTimespanClass implements Tx_CzSimpleCal_Domain_Interface_HasTimespan {
	
	protected
		$startDate = null,
		$endDate = null,
		$data = array()
	;
	
	public function __construct($startDate, $endDate) {
		$this->startDate = $startDate;
		$this->endDate   = $endDate;
	}
	
	public function getDateTimeObjectStart() {
		return $this->startDate;
	}
	
	public function getDateTimeObjectEnd() {
		return $this->endDate;
	}

	public function __call($method, $args) {
		if(strncmp('get', $method, 3) === 0) {
			$attrName = strtolower($method{3}).substr($method, 4);
			
			return $this->get($attrName);
		}
	}
	
	public function get($name) {
		if(!array_key_exists($name, $this->data)) {
			throw new InvalidArgumentException(sprintf('The value %s was not found.', $name));
		}
		return $this->data[$name];
	}
	
	public function set($name, $value = null) {
		if(is_string($name)) {
			$this->data[$name] = $value;
		} elseif(is_array($name)) {
			$this->data = array_merge(
				$this->data,
				$name
			);
		} else {
			throw new InvalidArgumentException('The value "name" must be a string or array.');
		}
	}
}
