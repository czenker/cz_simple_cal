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

class Tx_CzSimpleCal_Controller_EventAdministrationController extends Tx_Extbase_MVC_Controller_ActionController
{

	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventRepository
	 */
	protected $eventRepository;

	/**
	 * inject an eventRepository
	 *
	 * @param Tx_CzSimpleCal_Domain_Repository_EventRepository $eventRepository
	 */
	public function injectEventRepository(Tx_CzSimpleCal_Domain_Repository_EventRepository $eventRepository)
	{
		$this->eventRepository = $eventRepository;
	}

    /**
     * @var Tx_CzSimpleCal_Domain_Repository_CategoryRepository
     */
    protected $categoryRepository;

    /**
     * inject an categoryRepository
     * 
     * @param Tx_CzSimpleCal_Domain_Repository_CategoryRepository $categoryRepository
     */
    public function injectCategoryRepository(Tx_CzSimpleCal_Domain_Repository_CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
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
	public function getObjectManager()
	{
		if (is_null($this->objectManager)) {
			$this->objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		}
		return $this->objectManager;
	}


	/**
	 * list all events by the logged in user
	 *
	 *
	 */
	public function listAction()
	{
		$this->view->assign('events', $this->eventRepository->findAllByUserId($this->getFrontendUserId()));
	}

	/**
	 * Displays a form for creating a new event
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $fromEvent
	 * @return void
	 * @dontvalidate $fromEvent
	 */
	public function newAction(Tx_CzSimpleCal_Domain_Model_Event $fromEvent = NULL)
	{
		$this->abortOnMissingUser();
		$event = new Tx_CzSimpleCal_Domain_Model_Event();
		if ($fromEvent) {
			foreach (array(
				'categories',
				'description',
				'endDay',
				'endTime',
				'flickrTags',
				'locationAddress',
				'locationCity',
				'locationCountry',
				'locationName',
				'locationZip',
				'showPageInstead',
				'startDay',
				'startTime',
				'teaser',
				'title',
				'twitterHashtags'
			) as $field) {
				$getter = 'get' . ucfirst($field);
				$setter = 'set' . ucfirst($field);
				$event->$setter($fromEvent->$getter());
			}

			if ($event) {
				$this->setDefaults($event);
				$event->setCruserFe($this->getFrontendUserId());
			}
		}
		$categories = $this->getCategories();
		if(!$event->getCategory() && $categories->count() > 0) {
			$event->addCategory($categories->getFirst());
		}

		$this->view->assign('cats', $categories);
		$this->view->assign('newEvent', $event);
	}

	/**
	 * Creates a new event
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $newEvent
	 * @return void
	 * @dontvalidate $newEvent
	 */
	public function createAction(Tx_CzSimpleCal_Domain_Model_Event $newEvent)
	{
		$this->abortOnMissingUser();
		$this->setDefaults($newEvent);
		$newEvent->setCruserFe($this->getFrontendUserId());
		$this->view->assign('newEvent', $newEvent);

		if ($this->isEventValid($newEvent)) {
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
			$this->clearCache();
			$this->logEventLifecycle($newEvent, 1);
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
	public function editAction(Tx_CzSimpleCal_Domain_Model_Event $event)
	{
		$this->abortOnInvalidUser($event);
		$categories = $this->getCategories();

		$this->view->assign('cats', $categories);
		$this->view->assign('event', $event);
	}

	/**
	 * Updates an existing event
	 *
	 * @param $event Tx_CzSimpleCal_Domain_Model_Event
	 * @return void
	 * @dontvalidate $event
	 */
	public function updateAction(Tx_CzSimpleCal_Domain_Model_Event $event)
	{
		$this->abortOnInvalidUser($event);
		$this->view->assign('event', $event);


		if ($this->isEventValid($event)) {
			$this->eventRepository->update($event);

			// update index for event
			$this->getObjectManager()->get('Tx_CzSimpleCal_Indexer_Event')->update($event);

			$this->flashMessageContainer->add(
				sprintf('The event "%s" was updated.', $event->getTitle()),
				'',
				t3lib_FlashMessage::OK
			);
			$this->clearCache();
			$this->logEventLifecycle($event, 2);
			$this->redirect('list');
		}
	}

	/**
	 * Deletes an existing event
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event The event to delete
	 * @return void
	 * @dontvalidate $event
	 */
	public function deleteAction(Tx_CzSimpleCal_Domain_Model_Event $event)
	{
		$this->abortOnInvalidUser($event);

		// delete index for event
		$this->getObjectManager()->get('Tx_CzSimpleCal_Indexer_Event')->delete($event);

		$this->eventRepository->remove($event);
		$this->flashMessageContainer->add(
			sprintf('The event "%s" was deleted.', $event->getTitle()),
			'',
			t3lib_FlashMessage::OK
		);
		$this->clearCache();
		$this->logEventLifecycle($event, 3);
		$this->redirect('list');
	}

	/**
	 * abort the action if the user is invalid
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event The event
	 */
	protected function abortOnInvalidUser($event)
	{
		if (!$event->getCruserFe() || $this->getFrontendUserId() == null || ($event->getCruserFe() != $this->getFrontendUserId())) {
			$this->throwStatus(403, 'You are not allowed to do this.');
		}
	}

	/**
	 * abort the action if no user is logged in
	 */
	protected function abortOnMissingUser()
	{
		if ($this->getFrontendUserId() <= 0) {
			$this->throwStatus(403, 'Please log in.');
		}
	}

	/**
	 * set defaults on an object
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event
	 */
	public function setDefaults($event)
	{
		$event->setTimezone(date('e'));
//		if (isset($this->settings['overrides']['categories'])) {
//			$categories = $this->getObjectManager()->
//				get('Tx_CzSimpleCal_Domain_Repository_CategoryRepository')->
//				findAllByUids(t3lib_div::trimExplode(',', $this->settings['overrides']['categories']));
//			if (is_null($event->getCategories())) {
//				$event->setCategories($this->getObjectManager()->get('Tx_Extbase_Persistence_ObjectStorage'));
//			}
//
//			foreach ($categories as $category) {
//				$event->getCategories()->attach($category);
//			}
//		}
	}

	/**
	 * get the frontend User id
	 */
	public function getFrontendUserId()
	{
		$fe_user = $GLOBALS['TSFE']->fe_user->user['uid'];
		return $fe_user ? $fe_user : false;
	}


	/**
	 * validate the event
	 *
	 * Considerations
	 * ===============
	 * Extbase Validation for models and properties is not suitable for most of the validations needed
	 * as the validation would *always* be checked for the object - even if just displaying.
	 * So if we don't want a frontend user to enter an event in the past and did it
	 * using extbase's built-in validation, we would not be able to show *any* event
	 * in the past.
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event
	 * @return bool|array
	 */
	protected function isEventValid($event)
	{

		$validator = $this->getObjectManager()->get('Tx_CzSimpleCal_Domain_Validator_UserEventValidator');

		if (!$validator->isValid($event)) {
			$this->request->setErrors($validator->getErrors());
			return false;
		}

		$cats = array();
        foreach(t3lib_div::intExplode(',', $this->settings['feEditableCategories']) as $id){
            $cats[] = intval($id);
        }
        foreach($event->getCategories() as $cat){
            if(!in_array($cat->getUid(), $cats))  {
	            return false;
            };
        }

		return true;
	}

	/**
	 * clear the cache of the pages configured by the extension.
	 *
	 */
	protected function clearCache()
	{
		if (!$this->settings['clearCachePages']) {
			return false;
		}

		$pids = $this->settings['clearCachePages'];
		$pids = t3lib_div::trimExplode(',', $pids, true);

		if (empty($pids)) {
			return;
		}

		// init TCEmain object
		$tce = t3lib_div::makeInstance('t3lib_TCEmain');
		if (!$tce->BE_USER) {
			/* that's a little ugly here:
			 * We need some BE_USER as the cleanCache event will be logged to syslog.
			 * We could use an empty "t3lib_beUserAuth", but this would flood the
			 * syslog with entries of cleared caches.
			 *
			 * So we use this dummy class "Tx_CzSimpleCal_Utility_Null" that just
			 * ignores everything.
			 */
			$tce->BE_USER = t3lib_div::makeInstance('Tx_CzSimpleCal_Utility_Null');
		}
		foreach ($pids as $pid) {
			$pid = intval($pid);
			if ($pid > 0) {
				$tce->clear_cacheCmd($pid);
			}
		}

		return;
	}

	/**
	 * log if an event was created/updated/deleted to make this transparent in the backend
	 *
	 * @param Tx_CzSimpleCal_Domain_Model_Event $event
	 * @param string $action the action (one of 1->'new', 2->'updated', 3->'delete')
	 */
	protected function logEventLifecycle($event, $action)
	{
		$user = t3lib_div::makeInstance('t3lib_userAuthGroup');
		$actions = array(
			1 => 'added',
			2 => 'edited',
			3 => 'deleted',
		);
		$user->writelog(
			1, // type: log as TCEmain event
			$action, // action
			0, // error level
			0, // details_nr
			'fe_user "%s" (%s) ' . $actions[$action] . ' the event "%s" (%s).', // details
			array(
				$GLOBALS['TSFE']->fe_user->user['username'], //
				$GLOBALS['TSFE']->fe_user->user['uid'],
				$event->getTitle(),
				$event->getUid(),
			), // data
			'tx_czsimplecal_domain_model_event', //table
			$event->getUid(), // uid
			null, //---obsolete---
			$event->getPid() // pid
		);
	}

	/**
	 * Gets the allowed Categories
	 *
	 * @return array of Tx_CzSimpleCal_Domain_Model_Category
	 **/
	protected function getCategories()
	{
		return $this->categoryRepository->findAllByUids(
			t3lib_div::intExplode(',', $this->settings['feEditableCategories'])
		);
	}
}

?>