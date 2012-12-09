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
	 * @validate NotEmpty, StringLength(minimum=3,maximum=255)
	 */
	protected $title;

	/**
	 * a short teaser for this event
	 * @var string
	 * @validate String
	 */
	protected $teaser;
	
	/**
	 * a long description for this event
	 * @var string
	 * @validate String
	 */
	protected $description;

	/**
	 * the name of the location this event takes place in
	 * @var string
	 * @validate StringLength(maximum=255)
	 */
	protected $locationName;
	
	
	/**
	 * @var string
	 * @validate StringLength(maximum=255)
	 */
	protected $locationAddress;
	
	/**
	 * @var string locationZip
	 * @validate StringLength(maximum=12)
	 */
	protected $locationZip;
	
	
	/**
	 * @var string locationCity
	 * @validate StringLength(maximum=255)
	 */
	protected $locationCity;
	
	
	/**
	 * @var string locationCountry
	 * @validate StringLength(maximum=3)
	 */
	protected $locationCountry;
	
	/**
	 * a dummy address if no other record was given
	 * @var Tx_CzSimpleCal_Domain_Model_AddressDummy
	 */
	protected $locationDummy = null;
	
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
	 * @validate StringLength(maximum=255)
	 */
	protected $organizerName;
	
	/**
	 * @var string organizerAddress
	 * @validate String
	 */
	protected $organizerAddress;
	
	
	/**
	 * @var string organizerZip
	 * @validate StringLength(maximum=12)
	 */
	protected $organizerZip;
	
	
	/**
	 * @var string organizerCity
	 * @validate StringLength(maximum=255)
	 */
	protected $organizerCity;
	
	
	/**
	 * @var string organizerCountry
	 * @validate StringLength(maximum=3)
	 */
	protected $organizerCountry;
	
	
	/**
	 * a dummy address if no other record was given
	 * @var Tx_CzSimpleCal_Domain_Model_AddressDummy
	 */
	protected $organizerDummy = null;
	
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
	 * the image files associated with this event
	 * 
	 * @var string
	 */
	protected $images;
	
	/**
	 * alternative labels for images of this event
	 * 
	 * @var string
	 */
	protected $imagesAlternative;
	
	/**
	 * captions for images of this event
	 * 
	 * @var string
	 */
	protected $imagesCaption;
	
	/**
	 * files associated with this event
	 * 
	 * @var string
	 */
	protected $files;
	
	/**
	 * captions for files of this event
	 * 
	 * @var string
	 */
	protected $filesCaption;
	
	
	/**
	 * @var int cruserFe
	 */
	protected $cruserFe;
	

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
	 * Setter for locationAddress
	 *
	 * @param string $locationAddress the address of the location this event takes place in
	 * @return void
	 */
	public function setLocationAddress($locationAddress) {
		$this->locationAddress = $locationAddress;
	}

	/**
	 * Getter for locationAddress
	 *
	 * @return string the address of the location this event takes place in
	 */
	public function getLocationAddress() {
		return $this->locationAddress;
	}
	
	
	/**
	 * Setter for locationZip
	 *
	 * @param string $locationZip 
	 * @return void
	 */
	public function setLocationZip($locationZip) {
		$this->locationZip = $locationZip;
	}
	
	/**
	 * Getter for locationZip
	 *
	 * @return string $locationZip
	 */
	public function getLocationZip() {
		return $this->locationZip;
	}
	
	
	/**
	 * Setter for locationCity
	 *
	 * @param string $locationCity 
	 * @return void
	 */
	public function setLocationCity($locationCity) {
		$this->locationCity = $locationCity;
	}
	
	/**
	 * Getter for locationCity
	 *
	 * @return string $locationCity
	 */
	public function getLocationCity() {
		return $this->locationCity;
	}
	
	
	/**
	 * Setter for locationCountry
	 *
	 * @param string $locationCountry 
	 * @return void
	 */
	public function setLocationCountry($locationCountry) {
		$this->locationCountry = $locationCountry;
	}
	
	/**
	 * Getter for locationCountry
	 *
	 * @return string $locationCountry
	 */
	public function getLocationCountry() {
		return $this->locationCountry;
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
	 * Setter for organizerAddress
	 *
	 * @param string $organizerAddress 
	 * @return void
	 */
	public function setOrganizerAddress($organizerAddress) {
		$this->organizerAddress = $organizerAddress;
	}
	
	/**
	 * Getter for organizerAddress
	 *
	 * @return string $organizerAddress
	 */
	public function getOrganizerAddress() {
		return $this->organizerAddress;
	}
	
	
	/**
	 * Setter for organizerZip
	 *
	 * @param string $organizerZip 
	 * @return void
	 */
	public function setOrganizerZip($organizerZip) {
		$this->organizerZip = $organizerZip;
	}
	
	/**
	 * Getter for organizerZip
	 *
	 * @return string $organizerZip
	 */
	public function getOrganizerZip() {
		return $this->organizerZip;
	}
	
	
	/**
	 * Setter for organizerCity
	 *
	 * @param string $organizerCity 
	 * @return void
	 */
	public function setOrganizerCity($organizerCity) {
		$this->organizerCity = $organizerCity;
	}
	
	/**
	 * Getter for organizerCity
	 *
	 * @return string $organizerCity
	 */
	public function getOrganizerCity() {
		return $this->organizerCity;
	}
	
	
	/**
	 * Setter for organizerCountry
	 *
	 * @param string $organizerCountry 
	 * @return void
	 */
	public function setOrganizerCountry($organizerCountry) {
		$this->organizerCountry = $organizerCountry;
	}
	
	/**
	 * Getter for organizerCountry
	 *
	 * @return string $organizerCountry
	 */
	public function getOrganizerCountry() {
		return $this->organizerCountry;
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
	public function setCategories(Tx_Extbase_Persistence_ObjectStorage $categories = NULL) {
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
	 * @return Tx_CzSimpleCal_Domain_Model_Category
	 */
	public function getCategory() {
		if(is_null($this->categories) || $this->categories->count() === 0) {
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
		if(!is_object($this->categories)) {
			$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
			$this->categories = $objectManager->get('Tx_Extbase_Persistence_ObjectStorage');
		}
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
	 * Extbase internal functionality can't be used here as 
	 * the records need to be fetched from two different tables
	 *
	 * @return Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Exception> exception
	 */
	public function getExceptions() {
		if(is_null($this->exceptions_)) {
			/* @ugly: an object manager can't be fetched using dependency injection
			 * in domain model objects
			 */
			
			$exceptionRepository = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->
				get('Tx_CzSimpleCal_Domain_Repository_ExceptionRepository')
			;
			
			$this->exceptions_ = $exceptionRepository->findAllForEventId($this->uid);
		}
		
		return $this->exceptions_;
	}

	/**
	 * get all recurrances of this event
	 * 
	 * @return array
	 */
	public function getRecurrances() {
		$factory = new Tx_CzSimpleCal_Recurrance_Factory();
		return $factory->buildRecurranceForEvent($this);
	}
	
	/**
	 * check if this is an allday event
	 * 
	 * @return boolean
	 */
	public function isAlldayEvent() {
		return $this->startTime < 0;
	}
	
	/**
	 * check if this event has an endtime set
	 * 
	 * @return boolean
	 */
	public function hasEndTime() {
		return $this->endTime > -1;
	}
	
	/**
	 * check if this event is on one day only
	 * 
	 * @return boolean
	 */
	public function isOneDayEvent() {
		return $this->endDay < 0 || $this->endDay === $this->startDay;
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
	 * returns true if this is a recurrant event
	 * 
	 * @return boolean
	 */
	public function isRecurrant() {
		return !empty($this->recurranceType) && $this->recurranceType !== 'none';
	}
	
	/**
	 * get the organizer of the event
	 * 
	 * @return Tx_CzSimpleCal_Domain_Model_Organizer
	 */
	public function getOrganizer() {
		if($this->organizer) {
			return $this->organizer;
		}
		if(is_null($this->organizerDummy)) {
			$this->buildOrganizerDummy();
		}
		return $this->organizerDummy;
	}
	
	/**
	 * build the organizerDummy
	 * @return null
	 */
	protected function buildOrganizerDummy() {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->organizerDummy = $objectManager->get('Tx_CzSimpleCal_Domain_Model_AddressDummy');
		
		$this->organizerDummy->setName($this->organizerName);
		$this->organizerDummy->setAddress($this->organizerAddress);
		$this->organizerDummy->setZip($this->organizerZip);
		$this->organizerDummy->setCity($this->organizerCity);
		$this->organizerDummy->setCountry($this->organizerCountry);
		
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
		if($this->location) {
			return $this->location;
		}
		if(is_null($this->locationDummy)) {
			$this->buildLocationDummy();
		}
		return $this->locationDummy;
	}
	
	/**
	 * build the location
	 * @return null
	 */
	protected function buildLocationDummy() {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		$this->locationDummy = $objectManager->get('Tx_CzSimpleCal_Domain_Model_AddressDummy');
		
		$this->locationDummy->setName($this->locationName);
		$this->locationDummy->setAddress($this->locationAddress);
		$this->locationDummy->setZip($this->locationZip);
		$this->locationDummy->setCity($this->locationCity);
		$this->locationDummy->setCountry($this->locationCountry);
		
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
	
	/**
	 * the property slug
	 *
	 * @var string slug
	 */
	protected $slug;
	
	/**
	 * getter for slug
	 *
	 * @return string
	 */
	public function getSlug() {
		return $this->slug;
	}
	
	/**
	 * setter for slug
	 * 
	 * @param string $slug
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function setSlug($slug) {
		if(preg_match('/^[a-z0-9\-]*$/i', $slug) === false) {
			throw new InvalidArgument(sprintf('"%s" is no valid slug. Only ASCII-letters, numbers and the hyphen are allowed.'));
		}
		$this->slug = $slug;
		return $this;
	}
	
	/**
	 * generate a slug for this record
	 * 
	 * @return string
	 */
	public function generateSlug() {
		$value = $this->generateRawSlug();
		$value = Tx_CzSimpleCal_Utility_Inflector::urlize($value);
		
		$eventRepository = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->
			get('Tx_CzSimpleCal_Domain_Repository_EventRepository')
		;
		$slug = $eventRepository->makeSlugUnique($value, $this->uid);
		$this->setSlug($slug);
	}
	
	/**
	 * generate a raw slug that might have invalid characters
	 * 
	 * you could overwrite this if you want a different slug
	 * 
	 * @return string
	 */
	protected function generateRawSlug() {
		return $this->getTitle();
	}
	
	/**
	 * the property lastIndexed
	 *
	 * @var DateTime lastIndexed
	 */
	protected $lastIndexed;
	
	/**
	 * getter for lastIndexed
	 *
	 * @return DateTime
	 */
	public function getLastIndexed() {
		return $this->lastIndexed;
	}
	
	/**
	 * setter for lastIndexed
	 * 
	 * @param DateTime $lastIndexed
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function setLastIndexed($lastIndexed) {
		$this->lastIndexed = $lastIndexed;
		return $this;
	}
	
	/**
	 * an array of cached next appointments
	 * 
	 * @var array
	 */
	protected $nextAppointments = null;
	
	/**
	 * counts the number of requested nextAppointments
	 * 
	 * this is used to check if a database query has to been done
	 * of if the current result set can be taken
	 * 
	 * @var integer
	 */
	protected $nextAppointmentsCount = 0;
	
	/**
	 * get a list of next appointments
	 * 
	 * @param $limit
	 * @return array
	 */
	public function getNextAppointments($limit = 3) {
		if(is_null($this->nextAppointments) || $this->nextAppointmentsCount < $limit) {
			$eventIndexRepository = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager')->
				get('Tx_CzSimpleCal_Domain_Repository_EventIndexRepository')
			;
			$this->nextAppointments = $eventIndexRepository->
				findNextAppointmentsByEventUid($this->getUid(), $limit)
			;
			$this->nextAppointmentsCount = $limit;
		}
		if($this->nextAppointmentsCount === $limit) {
			return $this->nextAppointments;
		} else {
			return array_slice($this->nextAppointments, 0, $limit);
		}
	}
	
	/** 
	 * get the next appointment of this event if any
	 * 
	 * @return Tx_CzSimpleCal_Domain_Model_EventIndex | null
	 */
	public function getNextAppointment() {
		$appointments = $this->getNextAppointments(1);
		return empty($appointments) ? null : $appointments->getFirst();
	}
	
	/**
	 * if respected by the template a TYPO3 page is linked instead of the Event:show action 
	 *
	 * @var string showPageInstead
	 */
	protected $showPageInstead;
	
	/**
	 * getter for showPageInstead
	 *
	 * @return string
	 */
	public function getShowPageInstead() {
		return $this->showPageInstead;
	}
	
	/**
	 * setter for showPageInstead
	 * 
	 * @param string $showPageInstead
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function setShowPageInstead($showPageInstead) {
		if(!empty($showPageInstead) && !is_numeric($showPageInstead) && strpos($showPageInstead, '://') === false) {
			$showPageInstead = 'http://'.$showPageInstead;
		}
		$this->showPageInstead = $showPageInstead;
		return $this;
	}
	
	/**
	 * an array used internally to cache the images as an array
	 * 
	 * @var array
	 */
	protected $_cache_images = null;
	
	/**
	 * get all images as an array
	 * 
	 * @return array<Tx_CzEwlSponsor_Domain_Model_File>
	 */
	public function getImages() {
		if(is_null($this->_cache_images)) {
			t3lib_div::loadTCA('tx_czsimplecal_domain_model_event');
			$this->_cache_images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build(
				$this->images,
				$GLOBALS['TCA']['tx_czsimplecal_domain_model_event']['columns']['images']['config']['uploadfolder'],
				$this->imagesAlternative,
				$this->imagesCaption
			);
		}
		return $this->_cache_images;
	}
	
	/**
	 * an array used internally to cache the files as an array
	 * 
	 * @var array
	 */
	protected $_cache_files = null;
	
	/**
	 * get all files as an array
	 * 
	 * @return array<Tx_CzEwlSponsor_Domain_Model_File>
	 */
	public function getFiles() {
		if(is_null($this->_cache_files)) {
			t3lib_div::loadTCA('tx_czsimplecal_domain_model_event');
			$this->_cache_files = Tx_CzSimpleCal_Utility_FileArrayBuilder::build(
				$this->files,
				$GLOBALS['TCA']['tx_czsimplecal_domain_model_event']['columns']['files']['config']['uploadfolder'],
				'',
				$this->filesCaption
			);
		}
		return $this->_cache_files;
	}
	
	
	/**
	 * @var string
	 */
	protected $twitterHashtags = null;
	
	/**
	 * a cached array of twitter hashtags
	 * @var array
	 */
	protected $twitterHashtags_ = null;
	
	/**
	 * @var string
	 */
	protected $flickrTags = null;
	
	/**
	 * a cached array of flickr hashtags
	 * @var array
	 */
	protected $flickrTags_ = null;
	
	/**
	 * get an array of twitter hashtags used for this event
	 * 
	 * @return array
	 */
	public function getTwitterHashtagsArray() {
		if(is_null($this->twitterHashtags_)) {
			$this->buildTwitterHashtags();
		}
		return $this->twitterHashtags_;
	}
	
	/**
	 * get the twitterHashtags as string
	 * 
	 * @return string
	 */
	public function getTwitterHashtags() {
		return $this->twitterHashtags;
	}
	
	public function setTwitterHashtags($twitterHashtags) {
		$this->twitterHashtags = $twitterHashtags;
		$this->twitterHashtags_ = null;
	}

	/**
	 * build the array of twitter hashtags
	 * 
	 * @return null
	 */
	protected function buildTwitterHashtags() {
		$this->twitterHashtags_ = t3lib_div::trimExplode(',', $this->twitterHashtags, true);
		
		// make sure each tag starts with a hash ("#")
		foreach($this->twitterHashtags_ as &$hashtag) {
			if(strncmp($hashtag, '#', 1) !== 0) {
				$hashtag = '#'.$hashtag;
			}
		}
	}
	
	/**
	 * get an array of flickr tags
	 * 
	 * @return array
	 */
	public function getFlickrTagsArray() {
		if(is_null($this->flickrTags_)) {
			$this->buildFlickrTags();
		}
		return $this->flickrTags_;
	}
	
	/**
	 * get the flickr tags as string
	 * 
	 * @return string|false
	 */
	public function getFlickrTags() {
		return $this->flickrTags;
	}
	
	
	public function setFlickrTags($flickrTags) {
		$this->flickrTags = $flickrTags;
		$this->flickrTags_ = null;
	}

	/**
	 * build the array of flickr tags
	 * @return null
	 */
	protected function buildFlickrTags() {
		$this->flickrTags_ = t3lib_div::trimExplode(',', $this->flickrTags, true);
	}
	

	/**
	 * Setter for cruserFe
	 *
	 * @param int $cruserFe 
	 * @return void
	 */
	public function setCruserFe($cruserFe) {
		$this->cruserFe = $cruserFe;
	}
	
	/**
	 * Getter for cruserFe
	 *
	 * @return int $cruserFe
	 */
	public function getCruserFe() {
		return $this->cruserFe;
	}
	
	
}
?>