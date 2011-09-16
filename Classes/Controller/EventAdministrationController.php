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
 * Controller for the Event object with editing capabilities for frontend-users
 * 
 * (We use a seperate controller for this to avoid side effects with the
 *  BaseExtendableController)
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_CzSimpleCal_Controller_EventAdministrationController extends Tx_Extbase_MVC_Controller_ActionController {

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
	 * list all events by the logged in user
	 */
	public function listAction() {
		//TODO: user filtering
		$this->view->assign('events', $this->eventRepository->findAll());
	}
	
	
    /**
     * Displays a form for creating a new event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $newEvent 
     * @return void
     * @dontValidate $newEvent
     */
    public function newAction(Tx_CzSimpleCal_Domain_Model_Event $newEvent = NULL) {
        $this->view->assign('event', $newEvent);
    }

    /**
     * Creates a new event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $newEvent
     * @return void
     */
    public function createAction(Tx_CzSimpleCal_Domain_Model_Event $newEvent) {
    	
//    	$this->eventRepository->add($newEvent);
    	//
    }

    /**
     * Displays a form for editing an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     * @return void
     * @dontValidate $event
     */
    public function editAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
        $this->view->assign('event', $event);
    }

    /**
     * Updates an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     * @return void
     */
    public function updateAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
        // TODO access protection
//        $this->blogRepository->update($blog);
//        $this->addFlashMessage('updated');
//        $this->redirect('index');
    }

    /**
     * Deletes an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event The event to delete
     * @return void
     */
    public function deleteAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
        // TODO access protection
//        $this->blogRepository->remove($blog);
//        $this->addFlashMessage('deleted', t3lib_FlashMessage::INFO);
//        $this->redirect('index');
    }

}
?>