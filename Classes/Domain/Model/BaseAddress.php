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
 * a base class for addresses that extends tt_address
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Model_BaseAddress extends Tx_CzSimpleCal_Domain_Model_Base {
	/**
	 * the property pid
	 *
	 * @var integer pid
	 */
	protected $pid;
	
	/**
	 * the property hidden
	 *
	 * @var boolean hidden
	 */
	protected $hidden;
	
	/**
	 * getter for hidden
	 *
	 * @return boolean
	 */
	public function getHidden() {
		return $this->hidden;
	}
	
	/**
	 * setter for hidden
	 * 
	 * @param boolean $hidden
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setHidden($hidden) {
		$this->hidden = $hidden;
		return $this;
	}
	
	/**
	 * the property gender
	 *
	 * @var string gender
	 */
	protected $gender;
	
	/**
	 * getter for gender
	 *
	 * @return string
	 */
	public function getGender() {
		return $this->gender;
	}
	
	/**
	 * setter for gender
	 * 
	 * @param string $gender
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setGender($gender) {
		$this->gender = $gender;
		return $this;
	}
	
	/**
	 * the property name
	 *
	 * @var string name
	 */
	protected $name;
	
	/**
	 * getter for name
	 *
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * setter for name
	 * 
	 * @param string $name
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	
	/**
	 * the property firstName
	 *
	 * @var string firstName
	 */
	protected $firstName;
	
	/**
	 * getter for firstName
	 *
	 * @return string
	 */
	public function getFirstName() {
		return $this->firstName;
	}
	
	/**
	 * setter for firstName
	 * 
	 * @param string $firstName
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
		return $this;
	}
	
	/**
	 * the property middleName
	 *
	 * @var string middleName
	 */
	protected $middleName;
	
	/**
	 * getter for middleName
	 *
	 * @return string
	 */
	public function getMiddleName() {
		return $this->middleName;
	}
	
	/**
	 * setter for middleName
	 * 
	 * @param string $middleName
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setMiddleName($middleName) {
		$this->middleName = $middleName;
		return $this;
	}
	
	/**
	 * the property lastName
	 *
	 * @var string lastName
	 */
	protected $lastName;
	
	/**
	 * getter for lastName
	 *
	 * @return string
	 */
	public function getLastName() {
		return $this->lastName;
	}
	
	/**
	 * setter for lastName
	 * 
	 * @param string $lastName
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
		return $this;
	}
	
	/**
	 * the property title
	 *
	 * @var string title
	 */
	protected $title;
	
	/**
	 * getter for title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * setter for title
	 * 
	 * @param string $title
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}
	
	/**
	 * the property address
	 *
	 * @var string address
	 */
	protected $address;
	
	/**
	 * getter for address
	 *
	 * @return string
	 */
	public function getAddress() {
		return $this->address;
	}
	
	/**
	 * setter for address
	 * 
	 * @param string $address
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setAddress($address) {
		$this->address = $address;
		return $this;
	}
	
	/**
	 * the property building
	 *
	 * @var string building
	 */
	protected $building;
	
	/**
	 * getter for building
	 *
	 * @return string
	 */
	public function getBuilding() {
		return $this->building;
	}
	
	/**
	 * setter for building
	 * 
	 * @param string $building
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setBuilding($building) {
		$this->building = $building;
		return $this;
	}
	
	/**
	 * the property room
	 *
	 * @var string room
	 */
	protected $room;
	
	/**
	 * getter for room
	 *
	 * @return string
	 */
	public function getRoom() {
		return $this->room;
	}
	
	/**
	 * setter for room
	 * 
	 * @param string $room
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setRoom($room) {
		$this->room = $room;
		return $this;
	}
	
	/**
	 * the property birthday
	 *
	 * @var DateTime birthday
	 */
	protected $birthday;
	
	/**
	 * getter for birthday
	 *
	 * @return DateTime
	 */
	public function getBirthday() {
		return $this->birthday;
	}
	
	/**
	 * setter for birthday
	 * 
	 * @param DateTime $birthday
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setBirthday($birthday) {
		$this->birthday = $birthday;
		return $this;
	}
	
	/**
	 * the property phone
	 *
	 * @var string phone
	 */
	protected $phone;
	
	/**
	 * getter for phone
	 *
	 * @return string
	 */
	public function getPhone() {
		return $this->phone;
	}
	
	/**
	 * setter for phone
	 * 
	 * @param string $phone
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setPhone($phone) {
		$this->phone = $phone;
		return $this;
	}
	
	/**
	 * the property fax
	 *
	 * @var string fax
	 */
	protected $fax;
	
	/**
	 * getter for fax
	 *
	 * @return string
	 */
	public function getFax() {
		return $this->fax;
	}
	
	/**
	 * setter for fax
	 * 
	 * @param string $fax
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setFax($fax) {
		$this->fax = $fax;
		return $this;
	}
	
	/**
	 * the property mobile
	 *
	 * @var string mobile
	 */
	protected $mobile;
	
	/**
	 * getter for mobile
	 *
	 * @return string
	 */
	public function getMobile() {
		return $this->mobile;
	}
	
	/**
	 * setter for mobile
	 * 
	 * @param string $mobile
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setMobile($mobile) {
		$this->mobile = $mobile;
		return $this;
	}
	
	/**
	 * the property www
	 *
	 * @var string www
	 */
	protected $www;
	
	/**
	 * getter for www
	 *
	 * @return string
	 */
	public function getWww() {
		return $this->www;
	}
	
	/**
	 * setter for www
	 * 
	 * @param string $www
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setWww($www) {
		$this->www = $www;
		return $this;
	}
	
	/**
	 * the property email
	 *
	 * @var string email
	 */
	protected $email;
	
	/**
	 * getter for email
	 *
	 * @return string
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * setter for email
	 * 
	 * @param string $email
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setEmail($email) {
		$this->email = $email;
		return $this;
	}
	
	/**
	 * the property company
	 *
	 * @var string company
	 */
	protected $company;
	
	/**
	 * getter for company
	 *
	 * @return string
	 */
	public function getCompany() {
		return $this->company;
	}
	
	/**
	 * setter for company
	 * 
	 * @param string $company
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setCompany($company) {
		$this->company = $company;
		return $this;
	}
	
	/**
	 * the property city
	 *
	 * @var string city
	 */
	protected $city;
	
	/**
	 * getter for city
	 *
	 * @return string
	 */
	public function getCity() {
		return $this->city;
	}
	
	/**
	 * setter for city
	 * 
	 * @param string $city
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setCity($city) {
		$this->city = $city;
		return $this;
	}
	
	/**
	 * the property zip
	 *
	 * @var string zip
	 */
	protected $zip;
	
	/**
	 * getter for zip
	 *
	 * @return string
	 */
	public function getZip() {
		return $this->zip;
	}
	
	/**
	 * setter for zip
	 * 
	 * @param string $zip
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setZip($zip) {
		$this->zip = $zip;
		return $this;
	}
	
	/**
	 * the property region
	 *
	 * @var string region
	 */
	protected $region;
	
	/**
	 * getter for region
	 *
	 * @return string
	 */
	public function getRegion() {
		return $this->region;
	}
	
	/**
	 * setter for region
	 * 
	 * @param string $region
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setRegion($region) {
		$this->region = $region;
		return $this;
	}
	
	/**
	 * the property country
	 *
	 * @var string country
	 */
	protected $country;
	
	/**
	 * getter for country
	 *
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}
	
	/**
	 * setter for country
	 * 
	 * @param string $country
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setCountry($country) {
		$this->country = $country;
		return $this;
	}
	
	/**
	 * the property image
	 *
	 * @var string image
	 */
	protected $image;
	
	/**
	 * an array used internally to cache the images as an array
	 * 
	 * @var array
	 */
	protected $_cache_images = null;
	
	/**
	 * getter for image
	 *
	 * @deprecated
	 * @return string
	 */
	public function getImage() {
		return $this->image;
	}
	
	/**
	 * get all images as an array
	 * 
	 * @return array<Tx_CzEwlSponsor_Domain_Model_File>
	 */
	public function getImages() {
		if(is_null($this->_cache_images)) {
			t3lib_div::loadTCA('tt_address');
			$this->_cache_images = Tx_CzSimpleCal_Utility_FileArrayBuilder::build(
				$this->image,
				$GLOBALS['TCA']['tt_address']['columns']['image']['config']['uploadfolder']
			);
		}
		return $this->_cache_images;
	}
	
	/**
	 * setter for image
	 * 
	 * @deprecated not a very clever mechanism to set images. This method should be replaced by a setImagesMethod, that handles array input
	 * @param string $image
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setImage($image) {
		$this->image = $image;
		return $this;
	}
	
	/**
	 * the property description
	 *
	 * @var string description
	 */
	protected $description;
	
	/**
	 * getter for description
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}
	
	/**
	 * setter for description
	 * 
	 * @param string $description
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setDescription($description) {
		$this->description = $description;
		return $this;
	}
	
/**
	 * the property sorting
	 * 
	 * Note:
	 * This is a non-standard property on the 
	 * tt_address record, but the naming is quite
	 * common in TYPO3.
	 *
	 * @var integer sorting
	 */
	protected $sorting;
	
	/**
	 * getter for sorting
	 *
	 * @return integer
	 */
	public function getSorting() {
		return $this->sorting;
	}
	
	/**
	 * setter for sorting
	 * 
	 * @param integer $sorting
	 * @return Tx_CzSimpleCal_Domain_Model_Location
	 */
	public function setSorting($sorting) {
		$this->sorting = $sorting;
		return $this;
	}
	
	public function __toString() {
		return $this->getName();
	}
	
}
?>