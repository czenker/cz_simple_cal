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
 * an exception for an event in the calendar
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Model_Exception extends Tx_Extbase_DomainObject_AbstractEntity implements Tx_CzSimpleCal_Domain_Interface_HasTimespan {
	
	/**
	 * The title of this exception
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	/**
	 * the day that exception occurs on
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $day;

	/**
	 * the type of recurrance 
	 * 
	 * @var string
	 */
	protected $recurranceType;
	
	/**
	 * recurrance until this date
	 * @var integer
	 */
	protected $recurranceUntil;
	
	/**
	 * repeat the event this many times
	 * 
	 * @var integer
	 */
	protected $recurranceTimes;

	/**
	 * the timezone
	 * 
	 * @var string
	 */
	protected $timezone;
	
	
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Event>
	 */
	protected $events;
	
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_ExceptionGroup>
	 */
	protected $exceptionGroups;
	
	
	protected $startDateTime = null;
	protected $endDateTime = null;
	
	
	/**
	 * Setter for title
	 *
	 * @param string $title The title of this exception
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string The title of this exception
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Setter for day
	 *
	 * @param integer $day the day that exception occurs on
	 * @return void
	 */
	public function setDay($day) {
		$this->day = $day;
	}

	/**
	 * Getter for day
	 *
	 * @return integer the day that exception occurs on
	 */
	public function getDay() {
		return $this->day;
	}

	/**
	 * set the timezone of the user who created that event
	 * 
	 * @param string $timezone
	 * @return null
	 */
	public function setTimezone($timezone) {
		$this->timezone = $timezone;
	}
	
	/**
	 * get the timezone of the user who created that event
	 * 
	 * @return string
	 */
	public function getTimezone() {
		return $this->timezone;
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
	
	/**
	 * get a DateTime object of the recurranceUntil feature
	 * 
	 * @return DateTime
	 */
	public function getDateTimeObjectRecurranceUntil() {
		if(is_null($this->recurranceUntilDateTime)) {
			$this->createDateTimeObjects();
		}
		return $this->recurranceUntilDateTime;
	}
	
	public function setRecurranceUntil($recurranceUntil) {
		$this->recurranceUntil = $recurranceUntil;
	}
	
	public function getRecurranceTimes() {
		return $this->recurranceTimes; 
	}
	
	public function setRecurranceTimes($recurranceTimes) {
		$this->recurranceTimes = $recurranceTimes;
	}
	
	/**
	 * create the DateTimeObjects of start and end
	 * 
	 * @return null
	 * @see Classes/Domain/Model/Event->createDateTimeObjects()
	 */
	protected function createDateTimeObjects() {
	
		//start time
		$this->startDateTime = new Tx_CzSimpleCal_Utility_DateTime(
			'@'.$this->day // "@": let this be parsed as a unix timestamp
		);
		$this->startDateTime->setTimezone(new DateTimeZone($this->timezone));
		
		//end time
		$this->endDateTime = clone $this->startDateTime;
		$this->endDateTime->modify('+1 day -1 second');
		
		//recurrance until
		$this->recurranceUntilDateTime = new Tx_CzSimpleCal_Utility_DateTime(
			sprintf(
				'%s %sGMT',
				$this->recurranceUntil < 0 ? Tx_CzSimpleCal_Utility_Config::get('recurrenceEnd') : '@'.$this->recurranceUntil,
				'23:59:59'
			)
		);
		$this->recurranceUntilDateTime->setTimezone(new DateTimeZone($this->timezone));
		
	}
	

	
	/**
	 * get a DateTime object of the start
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectStart() {
		if(is_null($this->startDateTime)) {
			$this->createDateTimeObjects();
		}
		return $this->startDateTime;
	}
	
	/**
	 * get a DateTime object of the end
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectEnd() {
		if(is_null($this->endDateTime)) {
			$this->createDateTimeObjects();
		}
		return $this->endDateTime;
	}
	
	

}
?>