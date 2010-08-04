<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Christian Zenker <christian.zenker@599media.de>, 599media GmbH
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * 
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Model_EventIndex extends Tx_Extbase_DomainObject_AbstractEntity {
	
	/**
	 * the timestamp from the beginning of that event
	 * 
	 * @var integer
	 */
	protected $start;
	
	/**
	 * the timestamp from the end of that event
	 * 
	 * @var integer
	 */
	protected $end;
	
	/**
	 * the pid of the record
	 * 
	 * @var integer
	 */
	protected $pid;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $event;
	
	/**
	 * set the timestamp from the beginning of that event
	 * 
	 * @param integer $start
	 * @return null
	 */
	public function setStart($start) {
		$this->start = $start;
	}
	
	/**
	 * get the timestamp from the beginning of that event
	 * @return integer
	 */
	public function getStart() {
		return $this->start;
	}
	
	/**
	 * set the timestamp from the end of that event
	 * @param integer $end
	 * @return null
	 */
	public function setEnd($end) {
		$this->end = $end;
	}
	
	/**
	 * get the timestamp from the end of that event
	 * @return integer
	 */
	public function getEnd() {
		return $this->end;
	}
	
	/**
	 * set the pid of the record
	 * 
	 * @param $pid
	 * @return null
	 */
	public function setPid($pid) {
		$this->pid = $pid;
	}
	
	/**
	 * get the pid of the record
	 * 
	 * @return integer
	 */
	public function getPid() {
		return $this->pid;
	}
	
	public function setEvent($event) {
		$this->event = $event;
	}
	
	public function getEvent($event) {
		return $this->event;
	}
	
	
	/**
	 * create a new instance with data from a given array
	 * 
	 * @param $data
	 * @return Tx_CzSimpleCal_Domain_Model_EventIndex
	 */
	public static function fromArray($data) {
		t3lib_div::devLog('Hello World', 'cz_simple_cal', 2, $data);
		$obj = new Tx_CzSimpleCal_Domain_Model_EventIndex();
		
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
	
	/**
	 * tunnel all methods that were not found to the Event
	 * 
	 * @param $method
	 * @param $args
	 * @return mixed
	 */
	public function __call($method, $args) {
		$callback = array($this->event, $method);
		if(!is_callable($callback)) {
			throw new BadMethodCallException(sprintf('The method %s was neither found in %s nor in %s.', $method, get_class($this), get_class($this->event)));
		}
		
		return call_user_func_array($callback, $args);
	}
}
?>