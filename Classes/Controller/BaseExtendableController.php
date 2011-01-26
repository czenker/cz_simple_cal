<?php 

abstract class Tx_CzSimpleCal_Controller_BaseExtendableController extends Tx_Extbase_MVC_Controller_ActionController {
	
	protected $controllerName = '';
	
	/**
	 * an array of settings of the specific action used
	 * 
	 * @var array
	 */
	protected $actionSettings = null;
	
	/**
	 * @see Classes/MVC/Controller/Tx_Extbase_MVC_Controller_ActionController::initializeView()
	 */
	protected function initializeView($view) {
		/* set the template and partial path
		 * 
		 * this was added due to a bug. If the default action (dispatcher) was called, it created
		 * Tx_CzSimpleCal_View_EventIndex_Dispatch but did not set the templateRoot (only the
		 * discarded Template view had it). So we do it here.
		 */
		if($view instanceof Tx_Fluid_View_TemplateViewInterface) {
			$extbaseFrameworkConfiguration = Tx_Extbase_Dispatcher::getExtbaseFrameworkConfiguration();
			if (isset($extbaseFrameworkConfiguration['view']['templateRootPath']) && strlen($extbaseFrameworkConfiguration['view']['templateRootPath']) > 0) {
				$view->setTemplateRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['templateRootPath']));
			}
			if (isset($extbaseFrameworkConfiguration['view']['layoutRootPath']) && strlen($extbaseFrameworkConfiguration['view']['layoutRootPath']) > 0) {
				$view->setLayoutRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['layoutRootPath']));
			}
			if (isset($extbaseFrameworkConfiguration['view']['partialRootPath']) && strlen($extbaseFrameworkConfiguration['view']['partialRootPath']) > 0) {
				$view->setPartialRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['partialRootPath']));
			}
		}
		
		$view->assign('actionSettings', $this->actionSettings);
	}
	
	/**
	 * the only action the extbase dispatcher knows of
	 * 
	 * @return null
	 */
	public function dispatchAction() {
		if(!$this->controllerName) {
			t3lib_div::sysLog(
				sprintf(
					'There was no controller name set for class %s.',
					get_class($this)
				),
				'cz_simple_cal', 
				2
			);
			return '';
		}
		if(!isset($this->settings[$this->controllerName]) ||
				!is_array($this->settings[$this->controllerName]) ||
				!isset($this->settings[$this->controllerName]['allowedActions'])
		) {
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
		$actions = t3lib_div::trimExplode(',', $this->settings[$this->controllerName]['allowedActions'], true);
		reset($actions);
		$this->forward(current($actions));
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
		if($this->request->hasArgument('action') && $this->request->getArgument('action')) {
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
		if(!in_array($actionMethodName, t3lib_div::trimExplode(',', $this->settings[$this->controllerName]['allowedActions'], true))) {
			throw new Tx_Extbase_MVC_Exception_NoSuchAction('An action "' . $actionMethodName . '" does not exist in controller "' . get_class($this) . '".', 1186669086);
		}
		
		// throw error if action is not configured
		if(!array_key_exists($this->controllerName, $this->settings) || !array_key_exists('actions', $this->settings[$this->controllerName]) || !array_key_exists($actionMethodName, $this->settings[$this->controllerName]['actions'])) {
			throw new Tx_Extbase_MVC_Exception_NoSuchAction('An action "' . $actionMethodName . '" does not exist in controller "' . get_class($this) . '".', 1186669086);
		}
		
		// check if a fake action should be used
		if(array_key_exists('useAction', $this->settings[$this->controllerName]['actions'][$actionMethodName])) {
			$this->useActionName = $this->settings[$this->controllerName]['actions'][$actionMethodName]['useAction'].'Action';
			
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
	
	/**
	 * set up all settings correctly allowing overrides from flexforms 
	 * 
	 * @param string $actionMethodName
	 * @return null
	 */
	protected function initializeActionSettings($actionMethodName) {
		$this->actionSettings = &$this->settings[$this->controllerName]['actions'][$actionMethodName];
		
		// merge the settings from the flexform
		if(isset($this->settings['override']['action'])) {
			// this will override values if they are not empty
			$this->actionSettings = t3lib_div::array_merge_recursive_overrule($this->actionSettings, $this->settings['override']['action'], false, false);
		}
		
		// merge settings from getPost-values
		if(isset($this->actionSettings['getPostAllowed'])) {
			$allowed = t3lib_div::trimExplode(',', $this->actionSettings['getPostAllowed'], true);
			
			$this->actionSettings = array_merge(
				$this->actionSettings,
				array_intersect_key(
					$this->request->getArguments(),
					array_flip($allowed)
				)
			);
		}
	}
	
	protected function initializeSettings() {
		if(isset($this->settings['override'])) {
			// this will override values if they are not empty and they already exist (so no adding of keys)
			$this->settings = t3lib_div::array_merge_recursive_overrule($this->settings, $this->settings['override'], true, false);
		}
	}
	
	/**
	 * Initializes the current action
	 *
	 * @return void
	 */
	protected function initializeAction() {
		
		$this->initializeSettings();
	}
	
	
}