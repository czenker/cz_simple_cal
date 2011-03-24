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
 * a category of an event
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Model_Category extends Tx_CzSimpleCal_Domain_Model_Base {
	
	/**
	 * a title for this category
	 * @var string
	 */
	protected $title;
	
	
	
	/**
	 * Setter for title
	 *
	 * @param string $title a title for this category
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string a title for this category
	 */
	public function getTitle() {
		return $this->title;
	}
	
	/**
	 * if respected by the template a TYPO3 page is linked
	 * 
	 * as there is no Category-Controller yet, thats the only way to link a page according to 
	 * a controller. So you could create a page with information on your category for example.
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
	 * @return Tx_CzSimpleCal_Domain_Model_Category
	 */
	public function setShowPageInstead($showPageInstead) {
		$this->showPageInstead = $showPageInstead;
		return $this;
	}
	
}
?>