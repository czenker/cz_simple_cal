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
 *
 * @version $Id: JoinViewHelper.php$
 * @package Fluid
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @see Tx_CzSimpleCal_ViewHelpers_Array_JoinViewHelper
 * @api
 * @scope prototype
 *
 */
class Tx_CzSimpleCal_ViewHelpers_Array_JoinItemViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @return void
	 */
	public function render() {
		$viewHelperName = str_replace('_JoinItemViewHelper', '_JoinViewHelper', get_class($this));
		$key = 'items';
		if(!$this->viewHelperVariableContainer->exists($viewHelperName, $key)) {
			throw LogicException(sprintf('%s must be used as child of %s.', get_class($this), $viewHelperName));
		}
		
		$values = $this->viewHelperVariableContainer->get($viewHelperName, $key);
		$values[] = $this->renderChildren();
		
		$this->viewHelperVariableContainer->addOrUpdate($viewHelperName, $key, $values);
	}
}

?>