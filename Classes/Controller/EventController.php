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
 * Controller for the Event object
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */

class Tx_CzSimpleCal_Controller_EventController extends Tx_Extbase_MVC_Controller_ActionController {
	/**
	 * an array of settings of the specific action used
	 * 
	 * @var unknown_type
	 */
	protected $actionSettings = null;
	
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
		$this->eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$this->eventIndexRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventIndexRepository');
	}
	
	/**
	 * the only action the extbase dispatcher knows of
	 * 
	 * @return null
	 */
	public function dispatchAction() {
		call_user_func(array($this, $this->actionName));
		
		$this->view->assign('viewSettings', $this->viewSettings);
		$this->view->assign('actionSettings', $this->actionSettings);
		
		return $this->view->render($this->viewName);
	}
	
	/**
	 * builds a list of some events
	 * 
	 * @return null
	 */
	public function listAction() {
		$this->view->assign(
			'events',
			$this->eventIndexRepository->findAllWithSettings(array(
				'startDate' => $this->getStartDate(),
				'endDate'   => $this->getEndDate(),
				'limit'     => array_key_exists('maxEvents', $this->actionSettings) ? $this->actionSettings['maxEvents'] : null,
				'order'     => array_key_exists('order', $this->actionSettings) ? $this->actionSettings['order'] : null,
				'orderBy'   => array_key_exists('orderBy', $this->actionSettings) ? $this->actionSettings['orderBy'] : null,
			))
		);
	}
	
	public function countEventsAction() {
		$this->view->assign(
			'data',
			$this->eventIndexRepository->countAllWithSettings(array(
				'startDate' => $this->getStartDate(),
				'endDate'   => $this->getEndDate(),
				'limit'     => array_key_exists('maxEvents', $this->actionSettings) ? $this->actionSettings['maxEvents'] : null,
				'groupBy'     => array_key_exists('groupBy', $this->actionSettings) ? $this->actionSettings['groupBy'] : null
			))
		);
	}
	
	/**
	 * display a single event
	 * 
	 * @return null
	 */
	public function showAction() {
		if(isset($this->actionSettings['allowGPOverrideOfUid']) && $this->request->hasArgument('event')) {
			$uid = $this->request->getArgument('event');
		} elseif(isset($this->actionSettings['event'])) {
			$uid = $this->actionSettings['event']; 
		} else {
			$uid = null;
		}
		$uid = intval($uid);
		
		if($uid == 0) {
			$this->throwStatus(404, 'Not found', 'There was no event given that could be shown.');
		}
		
		$event = $this->eventIndexRepository->findOneByUid($uid);
		
		if(empty($event)) {
			$this->throwStatus(404, 'Not found', 'The requested event could not be found.');
		}
		
		$this->view->assign('event', $event);
	}
	
	
	/**
	 * get the start date of events that should be fetched
	 *
	 * @todo getDate support
	 * @return DateTime
	 */
	protected function getStartDate() {
		if(array_key_exists('startDate', $this->actionSettings)) {
			if(isset($this->actionSettings['useGetDate']) && $this->request->hasArgument('getDate')) {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->request->getArgument('getDate'));
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
			if(isset($this->actionSettings['useGetDate']) && $this->request->hasArgument('getDate')) {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->request->getArgument('getDate'));
				$date->modify($this->actionSettings['endDate']);
			} else {
				$date = new Tx_CzSimpleCal_Utility_DateTime($this->actionSettings['endDate']);
			}
			return $date;
		} else {
			return null;
		}
	}
	
/*
 * The following few methods are overrides of extbase methods.
 * They allow to to add new actions dynamically.
 * 
 * See the docblock for infos on what they change
 * 
 */	
	
	
	/**
	 * this is set if the currently called action is a user defined one
	 * 
	 * it holds the name of the real action that needs 
	 * 
	 * @var string
	 */
	protected $useActionName = null;
	
	/**
	 * Resolves and checks the current action method name
	 * 
	 * We override this method to allow dynamic adding of actions. Somehow using actions that were not configured in 
	 * ext_locaconf.php seems to work when configured in Typoscript, but not via GPvars.
	 * So we just need to change that.
	 *
	 * @return string Method name of the current action
	 * @throws Tx_Extbase_MVC_Exception_NoSuchAction if the action specified in the request object does not exist (and if there's no default action either).
	 */
	protected function resolveActionMethodName() {
		// this seems to work for actions set in TypoScript even if they are not configured in ext_localconf.php 
		$actionMethodName = $this->request->getControllerActionName() . 'Action';
		
		// the override for actions set in GPvars
		if($this->request->hasArgument('action')) {
			$actionMethodName = $this->request->getArgument('action') . 'Action';
		}
		
		$this->checkActionConfiguration($actionMethodName);
		
		return $actionMethodName;
	}
	
	
	/**
	 * check if action is configured
	 * 
	 * this is an added method.
	 * It checks if a method is configured in TypoScript and has an equivalent in the "real" actions of this class
	 * 
	 * @param $actionMethodName
	 * @return boolean
	 */
	protected function checkActionConfiguration($actionMethodName) {
		// strip the "...Action" from the name
		$actionMethodName = substr($actionMethodName, 0, -6);
		
		if($actionMethodName !== 'dispatch') {
			if(!array_key_exists('actions', $this->settings) || !array_key_exists($actionMethodName, $this->settings['actions'])) {
				throw new Tx_Extbase_MVC_Exception_NoSuchAction('An action "' . $actionMethodName . '" does not exist in controller "' . get_class($this) . '".', 1186669086);
			}
		}
		
		$this->actionSettings = &$this->settings['actions'][$actionMethodName];
		
		
		if(array_key_exists('useAction', $this->actionSettings)) {
			$this->useActionName = $this->actionSettings['useAction'].'Action';
			
			if(!is_callable(array($this, $this->useActionName))) {
				throw new Tx_Extbase_MVC_Exception_NoSuchAction(sprintf(
					'The useAction "%s" for the action "%s" does not exist in controller %s.',
					$this->useActionName,
					$actionMethodName,
					get_class($this)
				));
			}	
		}
		return true;
	}
	
	/**
	 * This method is overriden to allow proper assignment of parameters to fake actions.
	 * 
	 * Therefore we change the actionMethodName shortly if the called action is a "fake" action
	 *
	 * @return void
	 * @see initializeArguments()
	 */
	protected function initializeActionMethodArguments() {
		
		if(!is_null($this->useActionName)) {
			$temp = $this->actionMethodName;
			$this->actionMethodName = $this->useActionName;
		}
		
		parent::initializeActionMethodArguments();
		
		if(!is_null($this->useActionName)) {
			$this->actionMethodName = $temp;
		}
	}
	
	/**
	 * This method is overriden to allow proper assignment of parameters to fake actions.
	 * 
	 * Therefore we change the actionMethodName shortly if the called action is a "fake" action
	 *
	 * @return void
	 * @see initializeArguments()
	 */
	protected function initializeActionMethodValidators() {
		if(!is_null($this->useActionName)) {
			$temp = $this->actionMethodName;
			$this->actionMethodName = $this->useActionName;
		}
		
		parent::initializeActionMethodValidators();
		
		if(!is_null($this->useActionName)) {
			$this->actionMethodName = $temp;
		}
	}
	
	/**
	 * Override of this method to let the correct template be rendered
	 * 
	 * the TemplateView fetches the template name from the request and there is no way to 
	 * inject it dynamically (except for setting the full path, but this might be very error prone)
	 * So we give the template name in the render()-method
	 *
	 * @param string $actionMethodName Name of the action method to call
	 * @return void
	 * @api
	 */
	protected function callActionMethod() {
		$argumentsAreValid = TRUE;
		$preparedArguments = array();
		foreach ($this->arguments as $argument) {
			$preparedArguments[] = $argument->getValue();
		}

		if ($this->argumentsMappingResults->hasErrors()) {
			$actionResult = call_user_func(array($this, $this->errorMethodName));
		} else {
			$actionResult = call_user_func_array(array($this, $this->actionMethodName), $preparedArguments);
		}
		
	//changes start here
		if ($actionResult === NULL && $this->view instanceof Tx_Fluid_View_TemplateView) {
			$this->response->appendContent($this->view->render(substr($this->actionMethodName, 0, -6)));
	//changes end here
		} elseif ($actionResult === NULL && $this->view instanceof Tx_Extbase_MVC_View_ViewInterface) {
			$this->response->appendContent($this->view->render());
		} elseif (is_string($actionResult) && strlen($actionResult) > 0) {
			$this->response->appendContent($actionResult);
		}
	}
	
	
	
	/**
	 * dynamically add a called "fakeAction" 
	 * 
	 * @param $methodName
	 * @param $arguments
	 * @return unknown_type
	 */
	public function __call($methodName, $arguments) {
		if($methodName === $this->actionMethodName) {
			return call_user_func_array(array($this, $this->useActionName), $arguments);
		}
	}
}
?>