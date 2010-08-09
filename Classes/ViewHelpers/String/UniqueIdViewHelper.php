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

class Tx_CzSimpleCal_ViewHelpers_String_UniqueIdViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * generates a unique (and reproduceable) hash 
	 * 
	 * @param mixed $seed
	 * @param integer $length
	 * @param boolean $useEncryptionKey
	 */
	public function render($seed = null, $length = 32, $useEncryptionKey = true) {
		if(empty($seed)) {
			$seed = $this->renderChildren();
		}
		$seed = serialize($seed);
		if($useEncryptionKey) {
			$seed .= $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
		}
		
		$hash = md5($seed);
		
		if($length < 32) {
			$hash = substr($hash, 0, $length);
		}
		
		return $hash;
	}
}