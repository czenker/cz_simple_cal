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
 * an event in an calendar
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Model_Event extends Tx_Extbase_DomainObject_AbstractEntity implements Tx_CzSimpleCal_Domain_Interface_HasTimespan {
	
	/**
	 * an array of fields that if changed require a reindexing of all the events
	 * 
	 * @var array
	 */
	protected static $fieldsRequiringReindexing = array(
		'recurrance_type',
		'recurrance_until',
		'recurrance_times',
		'start_day',
		'start_time',
		'end_day',
		'end_time',
		'pid',
		'hidden', 
		'deleted'
	);
	
	/**
	 * the page-id this domain model resides on
	 * @var integer
	 */
	protected $pid;
	
	
	/**
	 * The title of this event
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;
	
	/**
	 * the day that event starts
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $startDay;
	
	/**
	 * the time this event starts (leave blank for an allday event)
	 * @var integer
	 */
	protected $startTime;
	
	/**
	 * the day this event ends (leave blank for an event on one day)
	 * @var integer
	 */
	protected $endDay;
	
	/**
	 * the time this event ends
	 * @var integer
	 */
	protected $endTime;
	
	/**
	 * the timezone of the user who created that event
	 * 
	 * @var string
	 */
	protected $timezone;
	
	/**
	 * a short teaser for this event
	 * @var string
	 */
	protected $teaser;
	
	/**
	 * a long description for this event
	 * @var string
	 */
	protected $description;
	
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
	 * the name of the location this event takes place in
	 * @var string
	 */
	protected $locationName;
	
	/**
	 * the name of the institution or person the event is organized by
	 * @var string
	 */
	protected $organizerName;
	
	/**
	 * category
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category>
	 */
	protected $category;
	
	/**
	 * exceptions for this event
	 * 
	 * @var array<Tx_CzSimpleCal_Domain_Model_Exception>
	 */
	protected $exceptions_ = null;
	
	/**
	 * is this record hidden
	 * 
	 * @var boolean
	 */
	protected $hidden;
	
	/**
	 * is this record deleted
	 * 
	 * @var boolean
	 */
	protected $deleted;
	
	
	
	
	
	
	/**
	 * @var Tx_CzSimpleCal_Utility_DateTime
	 */
	protected $startDateTime = null;
	
	/**
	 * @var Tx_CzSimpleCal_Utility_DateTime
	 */
	protected $endDateTime = null;
	
	/**
	 * @var Tx_CzSimpleCal_Utility_DateTime
	 */
	protected $recurranceUntilDateTime = null;
	
	
	
	
	
	
	/**
	 * Setter for title
	 *
	 * @param string $title The title of this event
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string The title of this event
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * Setter for startDay
	 *
	 * @param integer $startDay the day that event starts
	 * @return void
	 */
	public function setStartDay($startDay) {
		$this->startDay = $startDay;
	}

	/**
	 * Getter for startDay
	 *
	 * @return integer the day that event starts
	 */
	public function getStartDay() {
		return $this->startDay;
	}
	
	/**
	 * Setter for startTime
	 *
	 * @param integer $startTime the time this event starts (leave blank for an allday event)
	 * @return void
	 */
	public function setStartTime($startTime) {
		$this->startTime = $startTime;
	}

	/**
	 * Getter for startTime
	 *
	 * @return integer the time this event starts (leave blank for an allday event)
	 */
	public function getStartTime() {
		return $this->startTime;
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
	 * Setter for endDay
	 *
	 * @param integer $endDay the day this event ends (leave blank for an event on one day)
	 * @return void
	 */
	public function setEndDay($endDay) {
		$this->endDay = $endDay;
	}

	/**
	 * Getter for endDay
	 *
	 * @return integer the day this event ends (leave blank for an event on one day)
	 */
	public function getEndDay() {
		return $this->endDay;
	}
	
	/**
	 * Setter for endTime
	 *
	 * @param integer $endTime the time this event ends
	 * @return void
	 */
	public function setEndTime($endTime) {
		$this->endTime = $endTime;
	}

	/**
	 * Getter for endTime
	 *
	 * @return integer the time this event ends
	 */
	public function getEndTime() {
		return $this->endTime;
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
	
	/**
	 * create the DateTimeObjects of start and end
	 * 
	 * @return null
	 */
	protected function createDateTimeObjects() {
		
		/* little excursus on how TYPO3 treats dates and times before writing them to the database:
		 * 
		 * - input eval date will store the timestamp of midnight of the day this event takes place in the default timezone of the server.
		 *     so if the server stands in Greenwich 1-1-1970 will be stored as "0", but if your server is in Berlin it would be stored as "3600".
		 * - input eval time will just store the seconds from midnight. 
		 * 
		 * so if we add both the date and the time, we will get a valid timestamp of the event
		 * 
		 */ 
		
		
		$start = $this->startDay + max(0, $this->startTime);
		
		if($this->endTime < 0) {
			if($this->startTime < 0) {
				// if: no start and no end time -> this is an allday event -> set end as end of the day
				$end = max($this->endDay, $this->startDay) + 86399;
			} else {
				// if: no end but a start time -> this is an event with default length
				$end = max($this->endDay, $this->startDay) + $this->startTime;
			}
		} else {
			// if: there is an endTime -> just a casual event
			$end = max($this->endDay, $this->startDay) + $this->endTime;
		}
		
		//start time
		$this->startDateTime = new Tx_CzSimpleCal_Utility_DateTime(
			'@'.$start // "@": let this be parsed as a unix timestamp
		);
		$this->startDateTime->setTimezone(new DateTimeZone($this->timezone));
		
		//end time
		$this->endDateTime = new Tx_CzSimpleCal_Utility_DateTime(
			'@'.$end
		);
		$this->endDateTime->setTimezone(new DateTimeZone($this->timezone));
		
		//recurrance until
		$this->recurranceUntilDateTime = new Tx_CzSimpleCal_Utility_DateTime(
			sprintf(
				'%s %sGMT',
				$this->recurranceUntil < 0 ? Tx_CzSimpleCal_Utility_Config::get('recurrenceEnd') : date('Y-m-d', $this->recurranceUntil),
				'23:59:59'
			)
		);
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
	 
	
	/**
	 * Setter for teaser
	 *
	 * @param string $teaser a short teaser for this event
	 * @return void
	 */
	public function setTeaser($teaser) {
		$this->teaser = $teaser;
	}

	/**
	 * Getter for teaser
	 *
	 * @return string a short teaser for this event
	 */
	public function getTeaser() {
		return $this->teaser;
	}
	
	/**
	 * Setter for description
	 *
	 * @param string $description a long description for this event
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Getter for description
	 *
	 * @return string a long description for this event
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * Setter for locationName
	 *
	 * @param string $locationName the name of the location this event takes place in
	 * @return void
	 */
	public function setLocationName($locationName) {
		$this->locationName = $locationName;
	}

	/**
	 * Getter for locationName
	 *
	 * @return string the name of the location this event takes place in
	 */
	public function getLocationName() {
		return $this->locationName;
	}
	
	/**
	 * Setter for organizerName
	 *
	 * @param string $organizerName the name of the institution or person the event is organized by
	 * @return void
	 */
	public function setOrganizerName($organizerName) {
		$this->organizerName = $organizerName;
	}

	/**
	 * Getter for organizerName
	 *
	 * @return string the name of the institution or person the event is organized by
	 */
	public function getOrganizerName() {
		return $this->organizerName;
	}
	
	/**
	 * Setter for category
	 *
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category> $category category
	 * @return void
	 */
	public function setCategory(Tx_Extbase_Persistence_ObjectStorage $category) {
		$this->category = $category;
	}

	/**
	 * Getter for category
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category> category
	 */
	public function getCategory() {
		return $this->category;
	}
	
	/**
	 * Adds a Category
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Category The Category to be added
	 * @return void
	 */
	public function addCategory(Tx_CzSimpleCal_Domain_Model_Category $category) {
		$this->category->attach($category);
	}
	
	/**
	 * Removes a Category
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Category The Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_CzSimpleCal_Domain_Model_Category $category) {
		$this->category->detach($category);
	}
	
	/**
	 * Getter for exceptions
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Exception> exception
	 */
	public function getExceptions() {
		if(is_null($this->exceptions_)) {
			$exceptionRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_ExceptionRepository');
			
			$this->exceptions_ = $exceptionRepository->findAllForEventId($this->uid);
		}
		
		return $this->exceptions_;
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
	
	
	
	public function getRecurrances() {
		$factory = new Tx_CzSimpleCal_Recurrance_Factory();
		return $factory->buildRecurranceForEvent($this);
	}
	
	/**
	 * check if this is an allday event
	 * 
	 * @return boolean
	 */
	public function getIsAlldayEvent() {
		return $this->startTime < 0;
	}
	
	/**
	 * check if this event has an endtime set
	 * 
	 * @return boolean
	 */
	public function getHasEndTime() {
		return $this->endTime > -1;
	}
	
	/**
	 * check if this event is on one day only
	 * 
	 * @return boolean
	 */
	public function getIsOneDayEvent() {
		return $this->endDate < 0 || $this->endDate === $this->startDate;
	}
	
	/**
	 * get the pid of this record
	 * 
	 * @return integer
	 */
	public function getPid() {
		return $this->pid;
	}
	
	/**
	 * check if this record is enabled
	 * 
	 * @return boolean
	 */
	public function isEnabled() {
		return !$this->hidden && !$this->deleted;
	}
	
	/**
	 * an array of fields that if changed require a reindexing of all the events
	 * 
	 * @return array
	 */
	public static function getFieldsRequiringReindexing() {
		return self::$fieldsRequiringReindexing;
	}
	
	/**
	 * get a hash for this recurrance of the event
	 * 
	 * @return string
	 */
	public function getHash() {
		return md5(
			'event-'.
			$this->getUid().
			$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']
		);
	}
}
?>