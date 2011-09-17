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
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	/**
	 * get an instance of the objectManager
	 * 
	 * Note:
	 * =====
	 * injecting the container using dependency injection
	 * causes an error.
	 * 
	 * @return Tx_Extbase_Object_ObjectManager
	 */
	public function getObjectManager() {
		if(is_null($this->objectManager)) {
			$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		}
		return $this->objectManager;
	}

	
	/** 
	 * list all events by the logged in user
	 * 
	 * 
	 */
	public function listAction() {
		$this->view->assign('events', $this->eventRepository->findAllByUserId($this->getFrontendUserId()));
	}
	
	
    /**
     * Displays a form for creating a new event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $newEvent 
     * @return void
     * @dontvalidate $newEvent
     */
    public function newAction(Tx_CzSimpleCal_Domain_Model_Event $newEvent = NULL) {
    	$this->abortOnMissingUser();
    	if($newEvent) {
    		$this->setDefaults($newEvent);
    		$newEvent->setCruserFe($this->getFrontendUserId());
    	}
        $this->view->assign('event', $newEvent);
    }

    /**
     * Creates a new event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $newEvent
     * @return void
     * @dontvalidate $newEvent
     */
    public function createAction(Tx_CzSimpleCal_Domain_Model_Event $newEvent) {
    	$this->abortOnMissingUser();
    	$this->setDefaults($newEvent);
    	$newEvent->setCruserFe($this->getFrontendUserId());
    	$this->view->assign('newEvent', $newEvent);
    	
    	if($this->isEventValid($newEvent)) {
    		$this->eventRepository->add($newEvent);
    		
    		// persist event as the indexer needs an uid
    		$this->objectManager->get('Tx_Extbase_Persistence_Manager')->persistAll();
    		// create index for event
    		$this->getObjectManager()->get('Tx_CzSimpleCal_Indexer_Event')->create($newEvent);
    		
    		$this->flashMessageContainer->add(
    			sprintf('The event "%s" was created.', $newEvent->getTitle()),
    			'',
    			t3lib_FlashMessage::OK
    		);
    		$this->redirect('list');
    	}
    }

    /**
     * Displays a form for editing an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     * @return void
     * @dontvalidate $event
     */
    public function editAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
    	$this->abortOnInvalidUser($event);
        $this->view->assign('event', $event);
    }

    /**
     * Updates an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     * @return void
     * @dontvalidate $event
     */
    public function updateAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
    	$this->abortOnInvalidUser($event);
    	$this->view->assign('event', $event);
    	
    	
    	if($this->isEventValid($event)) {
    		$this->eventRepository->update($event);
    		
    		// update index for event
    		$this->getObjectManager()->get('Tx_CzSimpleCal_Indexer_Event')->update($event);
    		
    		$this->flashMessageContainer->add(
    			sprintf('The event "%s" was updated.', $event->getTitle()),
    			'',
    			t3lib_FlashMessage::OK
    		);
			$this->redirect('list');
    	}
    	
        // TODO access protection
//        $this->blogRepository->update($blog);
//        $this->redirect('index');
    }

    /**
     * Deletes an existing event
     *
     * @param Tx_CzSimpleCal_Domain_Model_Event $event The event to delete
     * @return void
     * @dontvalidate $event
     */
    public function deleteAction(Tx_CzSimpleCal_Domain_Model_Event $event) {
    	$this->abortOnInvalidUser($event);
    	
    	// delete index for event
    	$this->getObjectManager()->get('Tx_CzSimpleCal_Indexer_Event')->delete($event);
    	
        $this->eventRepository->remove($event);
		$this->flashMessageContainer->add(
    		sprintf('The event "%s" was deleted.', $event->getTitle()),
    		'',
    		t3lib_FlashMessage::OK
    	);
        $this->redirect('list');
    }
    
    /**
     * abort the action if the user is invalid
     * 
     * @param Tx_CzSimpleCal_Domain_Model_Event $event The event
     */
    protected function abortOnInvalidUser($event) {
    	if(!$event->getCruserFe() || $this->getFrontendUserId() == null || ($event->getCruserFe() != $this->getFrontendUserId())) {
    		$this->throwStatus(403, 'You are not allowed to do this.');
    	}
    }
    
	/**
     * abort the action if no user is logged in
     */
    protected function abortOnMissingUser() {
    	if($this->getFrontendUserId() <= 0) {
    		$this->throwStatus(403, 'Please log in.');
    	}
    }
    
    /**
     * set defaults on an object
     * 
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     */
    public function setDefaults($event) {
    	if(isset($this->settings['overrides']['categories'])) {
    		$categories = $this->getObjectManager()->
    			get('Tx_CzSimpleCal_Domain_Repository_CategoryRepository')->
    			findAllByUids(t3lib_div::trimExplode(',', $this->settings['overrides']['categories']))
    		;
    		if(is_null($event->getCategories())) {
    			$event->setCategories($this->getObjectManager()->get('Tx_Extbase_Persistence_ObjectStorage'));
    		}
    		
    		foreach($categories as $category) {
    			$event->getCategories()->attach($category);
    		}
    	}
    }
    
    /**
     * get the frontend User id
     */
    public function getFrontendUserId() {
	    $fe_user = $GLOBALS['TSFE']->fe_user->user['uid'];
	    return $fe_user ? $fe_user : false;
    }
    
    
    /** 
     * validate the event
     * 
     * Considerations
     * ===============
     * Extbase Validation for models and properties is not suitable for most of the validations needed
     * as the validation would *always* be checked - even if just displaying.
     * So if we don't want a frontend user to enter an event in the past and did it
     * using extbase's built-in validation, we would not be able to show *any* event 
     * in the past.
     * 
     * @param Tx_CzSimpleCal_Domain_Model_Event $event
     * @return bool|array
     */
    protected function isEventValid($event) {
    	
		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_UserEventValidator');
		
		if($validator->isValid($event)) {
			return true;
		} else {
			$this->request->setErrors($validator->getErrors());
		}
    	
    	//TODO
    	return false;
    }

}
?>