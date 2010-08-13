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

class Tx_CzSimpleCal_Controller_EventIndexController extends Tx_Extbase_MVC_Controller_ActionController {
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
		
		$this->initializeSettings();
		
		$this->eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$this->eventIndexRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventIndexRepository');
	}
	
	protected function initializeView($view) {
		$view->assign('actionSettings', $this->actionSettings);
	}
	
	/**
	 * the only action the extbase dispatcher knows of
	 * 
	 * @return null
	 */
	public function dispatchAction() {
		if(!isset($this->settings['allowedActions'])) {
			t3lib_div::sysLog(
				sprintf(
					'There were no allowedActions set on pageId %d, so there was nothing to display for the calendar.',
					$GLOBALS['TSFE']->id
				),
				'cz_simple_cal', 
				2
			);
			return '';
		}
		$actions = t3lib_div::trimExplode(',', $this->settings['allowedActions'], true);
		reset($actions);
		$this->forward(current($actions));
	}
	
	/**
	 * builds a list of some events
	 * 
	 * @return null
	 */
	public function listAction() {
		$this->view->assign(
			'events',
			$this->eventIndexRepository->findAllWithSettings(array_merge(
				$this->actionSettings,
				array(
					'startDate' => $this->getStartDate()->getTimestamp(),
					'endDate'   => $this->getEndDate()->getTimestamp()
				)
			))
		);
	}
	
	public function countEventsAction() {
		$this->view->assign(
			'data',
			$this->eventIndexRepository->countAllWithSettings(array_merge(
				$this->actionSettings,
				array(
					'startDate' => $this->getStartDate()->getTimestamp(),
					'endDate'   => $this->getEndDate()->getTimestamp()
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
	
	protected function initializeSettings() {
		if(isset($this->settings['override'])) {
			// this will override values if they are not empty and they already exist (so no adding of keys)
			$this->settings = t3lib_div::array_merge_recursive_overrule($this->settings, $this->settings['override'], true, false);
		}
	}
	
	/**
	 * set up all settings correctly allowing overrides from flexforms 
	 * 
	 * @param string $actionMethodName
	 * @return null
	 */
	protected function initializeActionSettings($actionMethodName) {
		$this->actionSettings = &$this->settings['EventIndex']['actions'][$actionMethodName];
		
		if(isset($this->settings['override']['action'])) {
			// this will override values if they are not empty and they already exist (so no adding of keys)
			$this->actionSettings = t3lib_div::array_merge_recursive_overrule($this->actionSettings, $this->settings['override']['action'], true, false);
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
		
		
		$this->initializeSettings();
		$this->checkActionConfiguration($actionMethodName);
		
		return $actionMethodName;
	}
	
	
	/**
	 * check if action is configured
	 * 
	 * this is an added method.
	 * It checks if an action method is configured in TypoScript and has an equivalent in the "real" actions of this class
	 * 
	 * @param $actionMethodName
	 * @return boolean
	 */
	protected function checkActionConfiguration($actionMethodName) {
		// strip the "...Action" from the name
		$actionMethodName = substr($actionMethodName, 0, -6);
		if($actionMethodName === 'dispatch') {
			// dispatcher will redirect anyways -> so no further need of checking
			return;
		}
		
		// throw error if action is not allowed in settings
		if(!in_array($actionMethodName, t3lib_div::trimExplode(',', $this->settings['allowedActions'], true))) {
			throw new Tx_Extbase_MVC_Exception_NoSuchAction('An action "' . $actionMethodName . '" does not exist in controller "' . get_class($this) . '".', 1186669086);
		}
		
		// throw error if action is not configured
		if(!array_key_exists('EventIndex', $this->settings) || !array_key_exists('actions', $this->settings['EventIndex']) || !array_key_exists($actionMethodName, $this->settings['EventIndex']['actions'])) {
			throw new Tx_Extbase_MVC_Exception_NoSuchAction('An action "' . $actionMethodName . '" does not exist in controller "' . get_class($this) . '".', 1186669086);
		}
		
		// check if a fake action should be used
		if(array_key_exists('useAction', $this->settings['EventIndex']['actions'][$actionMethodName])) {
			$this->useActionName = $this->settings['EventIndex']['actions'][$actionMethodName]['useAction'].'Action';
			
			if(!is_callable(array($this, $this->useActionName))) {
				throw new Tx_Extbase_MVC_Exception_NoSuchAction(sprintf(
					'The useAction "%s" for the action "%s" does not exist in controller %s.',
					$this->useActionName,
					$actionMethodName,
					get_class($this)
				));
			}	
		}
		
		$this->initializeActionSettings($actionMethodName);
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
		} else {
			throw new BadMethodCallException(sprintf('%s does not implement the called %s method.', get_class($this), $methodName));
		}
	}
}
?>