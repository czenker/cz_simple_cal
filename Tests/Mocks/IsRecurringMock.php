<?php 

require_once t3lib_extMgm::extPath('cz_simple_cal').'Classes/Domain/Interface/HasTimespan.php';
require_once t3lib_extMgm::extPath('cz_simple_cal').'Classes/Domain/Interface/IsRecurring.php';

class Tx_CzSimpleCalTests_Mocks_IsRecurringMock implements Tx_CzSimpleCal_Domain_Interface_IsRecurring {
	
	protected $start = null;
	protected $end = null;
	protected $recurranceType = null;
	protected $recurranceUntil = null;
	protected $recurranceWeeklyInterval = null;
	
	/**
	 * get the start of this domain model
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectStart() {
		return new Tx_CzSimpleCal_Utility_DateTime($this->start);
	}
	
	public function setStart($start) {
		$this->start = $start;
	}
	
	/**
	 * get the end of this domain model
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectEnd() {
		return new Tx_CzSimpleCal_Utility_DateTime($this->end);
	}
	
	public function setEnd($end) {
		$this->end = $end;
	}
	
	public function getRecurranceType() {
		return $this->recurranceType;
	}
	
	public function setRecurranceType($recurranceType) {
		$this->recurranceType = $recurranceType;
	}
	
	public function getRecurranceUntil() {
		return $this->recurranceUntil;
	}
	
	public function getDateTimeObjectRecurranceUntil() {
		return new Tx_CzSimpleCal_Utility_DateTime($this->recurranceUntil);
	}
	
	public function setRecurranceUntil($recurranceUntil) {
		$this->recurranceUntil = $recurranceUntil;
	}
	
	public function getRecurranceWeeklyInterval() {
		return $this->recurranceWeeklyInterval;
	}
	
	public function setRecurranceWeeklyInterval($recurranceWeeklyInterval) {
		$this->recurranceWeeklyInterval = $recurranceWeeklyInterval;
	}
	
	/**
	 * create a new instance with data from a given array
	 * 
	 * @param $data
	 * @return Tx_CzSimpleCal_Tests_Mocks_IsRecurringMock
	 */
	public static function fromArray($data) {
		$className = get_class($this);
		$obj = new $className();
		
		foreach($data as $name => $value) {
			$methodName = 'set'.t3lib_div::underscoredToUpperCamelCase($name);
			
			// check if there is a setter defined (use of is_callable to check if the scope is public)
			if(!is_callable(array($obj,	$methodName))) {
				throw new InvalidArgumentException(sprintf('Could not find the %s method to set %s in %s.', $methodName, $name, get_class($obj)));
			}
			
			call_user_func(array($obj, $methodName), $value);
		}
		
		return $obj;		
	}
}
