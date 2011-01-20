<?php

/*           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                  Version 2, December 2004
 *
 * Copyright (C) 2010 Christian Zenker <christian.zenker@599media.de>
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 *         DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 */

/**
 * A view helper to return true if one of the values is not empty
 * 
 * @license WTFPL
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Condition_OneNotEmptyViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param array $values the values
	 * @return boolean if the condition is met
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($values) {
		foreach($values as $value) {
			if(!empty($value)) {
				return true;
			}
		}
		return false;
	}
}
?>