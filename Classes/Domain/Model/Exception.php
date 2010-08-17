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
class Tx_CzSimpleCal_Domain_Model_Exception extends Tx_CzSimpleCal_Domain_Model_BaseEvent {
	
	/**
	 * The title of this exception
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_Event>
	 */
	protected $events;
	
	/**
	 * @var Tx_Extbase_Persistence_ObjectStorage<Tx_CzSimpleCal_Domain_Model_ExceptionGroup>
	 */
	protected $exceptionGroups;

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
}
?>