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
 * Controller for the EventIndex object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_CzSimpleCal_Controller_EventIndexController extends Tx_CzSimpleCal_Controller_BaseExtendableController {
	
	protected $controllerName = 'EventIndex';
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventRepository
	 */
	protected $eventRepository;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventIndexRepository
	 */
	protected $eventIndexRepository;

	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		
		$this->initializeSettings();
		
		$this->eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$this->eventIndexRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventIndexRepository');
	}
	
	/**
	 * builds a list of some events
	 * 
	 * @return null
	 */
	public function listAction() {
		$start = $this->getStartDate();
		$end = $this->getEndDate();
		
		$this->view->assign('start', $start);
		$this->view->assign('end', $end);
		
		$this->view->assign(
			'events',
			$this->eventIndexRepository->findAllWithSettings(array_merge(
				$this->actionSettings,
				array(
					'startDate' => $start->getTimestamp(),
					'endDate'   => $end->getTimestamp()
				)
			))
		);
	}
	
	public function countEventsAction() {
		$start = $this->getStartDate();
		$end = $this->getEndDate();
		
		$this->view->assign('start', $start);
		$this->view->assign('end', $end);
		
		$this->view->assign(
			'data',
			$this->eventIndexRepository->countAllWithSettings(array_merge(
				$this->actionSettings,
				array(
					'startDate' => $start->getTimestamp(),
					'endDate'   => $end->getTimestamp()
				)
			))
		);
	}
	
	/**
	 * display a single event
	 * 
	 * @return null
	 */
	public function showAction(Tx_CzSimpleCal_Domain_Model_EventIndex $event) {
		
		if(empty($event)) {
			$this->throwStatus(404, 'Not found', 'The requested event could not be found.');
		}
		
		$this->view->assign('event', $event);
	}
	
	
	/**
	 * get the start date of events that should be fetched
	 *
	 * @return DateTime
	 */
	protected function getStartDate() {
		if(array_key_exists('startDate', $this->actionSettings)) {
			if(isset($this->actionSettings['getDate'])) {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->actionSettings['getDate']);
				$date->modify($this->actionSettings['startDate']);
			} else {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->actionSettings['startDate']);
			}
			return $date;
		} else {
			return null;
		}
	}
	
	/**
	 * get the end date of events that should be fetched
	 * 
	 * @todo getDate support
	 * @return DateTime
	 */
	protected function getEndDate() {
		if(array_key_exists('endDate', $this->actionSettings)) {
			if(isset($this->actionSettings['getDate'])) {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->actionSettings['getDate']);
				$date->modify($this->actionSettings['endDate']);
			} else {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->actionSettings['endDate']);
			}
			return $date;
		} else {
			return null;
		}
	}
}
?>