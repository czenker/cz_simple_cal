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
class Tx_CzSimpleCal_Domain_Model_Event extends Tx_CzSimpleCal_Domain_Model_BaseEvent {
	
	/**
	 * an array of fields that if changed require a reindexing of all the events
	 * 
	 * @var array
	 */
	protected static $fieldsRequiringReindexing = array(
		'recurrance_type',
		'recurrance_subtype',
		'recurrance_until',
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
	 * the name of the location this event takes place in
	 * @var string
	 */
	protected $locationName;
	
	/**
	 * the organizer of the event
	 * 
	 * @lazy
	 * @var Tx_CzSimpleCal_Domain_Model_Location
	 */
	protected $location;
	
	/**
	 * the name of the institution or person the event is organized by
	 * @var string
	 */
	protected $organizerName;
	
	/**
	 * the organizer of the event
	 * 
	 * @lazy
	 * @var Tx_CzSimpleCal_Domain_Model_Organizer
	 */
	protected $organizer;
	
	/**
	 * categories
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category>
	 */
	protected $categories;
	
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
	 * @param Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category> $categories categories
	 * @return void
	 */
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories) {
		$this->categories = $categories;
	}

	/**
	 * Getter for category
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Category> categories
	 */
	public function getCategories() {
		return $this->categories;
	}
	
	/**
	 * getter for the first category
	 *
	 * @return type
	 */
	public function getCategory() {
		if(!$this->categories) {
			return null;
		}
		$this->categories->rewind();
		return $this->categories->current();
	}
	
	/**
	 * Adds a Category
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Category The Category to be added
	 * @return void
	 */
	public function addCategory(Tx_CzSimpleCal_Domain_Model_Category $category) {
		$this->categories->attach($category);
	}
	
	/**
	 * Removes a Category
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Category The Category to be removed
	 * @return void
	 */
	public function removeCategory(Tx_CzSimpleCal_Domain_Model_Category $category) {
		$this->categories->detach($category);
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
	 * get the organizer of the event
	 * 
	 * @return Tx_CzSimpleCal_Domain_Model_Organizer
	 */
	public function getOrganizer() {
		return $this->organizer;
	}
	
	/**
	 * setter for organizer
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_Organizer $organizer
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function setOrganizer($organizer) {
		$this->organizer = $organizer;
		return $this;
	}
	
	/**
	 * getter for location
	 *
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function getLocation() {
		return $this->location;
	}
	
	/**
	 * setter for location
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_Location $location
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function setLocation($location) {
		$this->location = $location;
		return $this;
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