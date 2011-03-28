<?php

/*                                                                        *
 * This script belongs to the FLOW3 package "Fluid".                      *
 *                                                                        *
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
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_CzSimpleCal_ViewHelpers_Widget_EventIndex_ListViewHelper extends Tx_Fluid_Core_Widget_AbstractWidgetViewHelper {

	/**
	 * @var Tx_CzSimpleCal_ViewHelpers_Widget_EventIndex_Controller_ListController
	 */
	protected $controller;

	/**
	 * @param Tx_CzSimpleCal_ViewHelpers_Widget_EventIndex_Controller_ListController $controller
	 * @return void
	 */
	public function injectController(Tx_CzSimpleCal_ViewHelpers_Widget_EventIndex_Controller_ListController $controller) {
		$this->controller = $controller;
	}

	
	/**
	 * Initialize all arguments. You need to override this method and call
	 * $this->registerArgument(...) inside this method, to register all your arguments.
	 *
	 * @return void
	 */
	public function initializeArguments() {
		$this->registerArgument('startDate', 'mixed', 'startDate', false, null);
		$this->registerArgument('endDate', 'mixed', 'endDate', false, null);
		$this->registerArgument('maxEvents', 'integer', 'maxEvents', false, 3);
		$this->registerArgument('order', 'string', 'order', false, 'asc');
		$this->registerArgument('orderBy', 'string', 'orderBy', false, 'startDate');
		$this->registerArgument('includeStartedEvents', 'integer', 'includeStartedEvents', false, null);
		$this->registerArgument('excludeOverlongEvents', 'integer', 'excludeOverlongEvents', false, null);
		$this->registerArgument('filter', 'array', 'filter', false, null);
	}
	
	/**
	 * @return string
	 */
	public function render() {
		return $this->initiateSubRequest();
	}
}

?>