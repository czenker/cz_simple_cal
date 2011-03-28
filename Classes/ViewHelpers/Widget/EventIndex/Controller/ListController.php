<?php

/*                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_CzSimpleCal_ViewHelpers_Widget_EventIndex_Controller_ListController extends Tx_Fluid_Core_Widget_AbstractWidgetController {

	/**
	 * @param Tx_CzSimpleCal_Domain_Repository_EventIndexRepository $eventIndexRepository
	 */
	public function injectEventIndexRepository(Tx_CzSimpleCal_Domain_Repository_EventIndexRepository $eventIndexRepository) {
		$this->eventIndexRepository = $eventIndexRepository;
	}
	
	/**
	 * the action settings to use for fetching the events
	 * 
	 * @var array
	 */
	protected $actionSettings = array();
	
	/**
	 * @return void
	 */
	public function initializeAction() {
		foreach(array('maxEvents', 'order', 'orderBy', 'includeStartedEvents', 'excludeOverlongEvents', 'filter') as $argumentName) {
			if($this->widgetConfiguration->offsetExists($argumentName)) {
				$this->actionSettings[$argumentName] = $this->widgetConfiguration[$argumentName];
			}
		}
		foreach(array('startDate', 'endDate') as $argumentName) {
			if($this->widgetConfiguration->offsetExists($argumentName)) {
				$this->actionSettings[$argumentName] = $this->normalizeArgumentToTimestamp($this->widgetConfiguration[$argumentName]);
			}
		}
	}
	
	/**
	 * normalizes anything that describes a time
	 * and sets it to be a timestamp
	 * 
	 * @param mixed $value
	 * @return void
	 */
	protected function normalizeArgumentToTimestamp($value) {
		if(empty($value)) {
			return;
		} elseif(is_numeric($value)) {
			return t3lib_div::intInRange($this->argumentName, 0);
		} elseif(is_string($value)) {
			return Tx_CzSimpleCal_Utility_StrToTime::strtotime($value);
		} elseif($value instanceof DateTime) {
			return intval($value->format('U'));
		}
		return;
	}
	
	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign(
			'events',
			$this->eventIndexRepository->findAllWithSettings($this->actionSettings)
		);
	}
	
	/**
	 * Allows the widget template root path to be overriden via the framework configuration,
	 * e.g. plugin.tx_extension.view.widget.<WidgetViewHelperClassName>.templateRootPath
	 * 
	 * This implementation was suggested in the ticket below, but was not yet
	 * integrated in the Extbase core.
	 * 
	 * @todo remove, override or modify this method as soon as this feature is in extbase
	 * @param Tx_Extbase_MVC_View_ViewInterface $view
	 * @see Classes/Core/Widget/Tx_Fluid_Core_Widget_AbstractWidgetController::setViewConfiguration()
	 * @see http://forge.typo3.org/issues/10823
	 */
	protected function setViewConfiguration(Tx_Extbase_MVC_View_ViewInterface $view) {
		$extbaseFrameworkConfiguration = $this->configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
		$widgetViewHelperClassName = $this->request->getWidgetContext()->getWidgetViewHelperClassName();
		
		if (isset($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath'])
				&& strlen($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath']) > 0
				&& method_exists($view, 'setTemplateRootPath')) {
			
			if($this->widgetConfiguration->hasArgument('templateFilePath')) {
				$view->setTemplatePathAndFilename(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath']).$this->widgetConfiguration['templateFilePath']);
			} else {
				$view->setTemplateRootPath(t3lib_div::getFileAbsFileName($extbaseFrameworkConfiguration['view']['widget'][$widgetViewHelperClassName]['templateRootPath']));
			}
			
		} elseif($this->widgetConfiguration->hasArgument('templateFilePath')) {
			$view->setTemplatePathAndFilename($this->widgetConfiguration['templateFilePath']);
		}
	}
}

?>