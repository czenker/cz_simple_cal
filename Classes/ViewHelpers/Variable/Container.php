<?php 

class Tx_CzSimpleCal_ViewHelpers_Variable_Container {
	
	protected $values = array();
	
	public function get($name) {
		if(!$this->exists($name)) {
			throw new InvalidArgumentException(sprintf('A value for the name "%s" was not stored.', $name));
		}
		return $this->values[$name];
	}
	
	public function set($name, $value) {
		$this->values[$name] = $value;
	}
	
	public function exists($name) {
		return array_key_exists($name, $this->values);
	}
}