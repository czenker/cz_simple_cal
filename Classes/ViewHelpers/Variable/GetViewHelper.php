<?php

/*
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
 * Initializes the variable holder
 * 
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Variable_GetViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	protected $className = 'Tx_CzSimpleCal_ViewHelpers_Variable_InitViewHelper';
	
	/**
	 * @param string $name
	 */
	public function render($name) {
		
		if (!$this->viewHelperVariableContainer->exists($this->className, 'container')) {
			throw new LogicException(sprintf('%s should be used inside %s.', get_class($this), $this->className));
		}
		
		$container = $this->viewHelperVariableContainer->get($this->className, 'container');
		
		return $container->get($name);
	}
}
?>