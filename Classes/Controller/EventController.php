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

class Tx_CzSimpleCal_Controller_EventController extends Tx_CzSimpleCal_Controller_BaseExtendableController {
	
	/**
	 * override this property so that no empty view will be created
	 */
	protected $defaultViewObjectName = 'Tx_CzSimpleCal_View_Event'; 
	
	protected $controllerName = 'Event';
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventRepository
	 */
	protected $eventRepository;

	/**
	 * inject an eventRepository
	 * 
	 * @param Tx_CzSimpleCal_Domain_Repository_EventRepository $eventRepository
	 */
	public function injectEventRepository(Tx_CzSimpleCal_Domain_Repository_EventRepository $eventRepository) {
		$this->eventRepository = $eventRepository;
	}
	
	/**
	 * display a single event
	 * 
	 * @param integer $event
	 * @return null
	 */
	public function showAction($event) {
		
		/* don't let Extbase fetch the event
		 * as you won't be able to extend the model
		 * via an extension
		 */
		$event = $this->eventRepository->findByUid($event);
		
		
		if(empty($event)) {
			$this->throwStatus(404, 'Not found', 'The requested event could not be found.');
		}
		
		$this->view->assign('event', $event);
	}

}
?>