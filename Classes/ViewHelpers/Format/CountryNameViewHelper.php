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
 * format a localized name of a country by its isoCode
 * 
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Format_CountryNameViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Get the localized name of a country from its country code
	 *
	 * @param string $isoCode the three-letter isocode of the country (as given by static_info_tables)
	 * @return string localized country name
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($isoCode) {
		if(empty($isoCode)) {
			return '';
		}
		
		(!is_null(self::$staticInfoObject)) || self::init();
		
		if(self::$staticInfoObject === false) {
			// if init went wrong
			return $isoCode;
		}
		
		return self::$staticInfoObject->getStaticInfoName('COUNTRIES', $isoCode);
	}
	
	/**
	 * @var tx_staticinfotables_pi1
	 */
	protected static $staticInfoObject = null;
	
	/**
	 * init static info tables to use with this view helper
	 * 
	 * @return null
	 */
	protected static function init() {
		// check if class was already initialized
		if(!is_null(self::$staticInfoObject)) {
			return;
		}
		
		// check if static_info_tables is installed
		if(!t3lib_extMgm::isLoaded('static_info_tables')) {
			self::$staticInfoObject = false;
			t3lib_div::devLog('static_info_tables needs to be installed to use '.get_class(self), get_class(self), 1);
			return;
		}
		
		require_once(t3lib_extMgm::extPath('static_info_tables').'pi1/class.tx_staticinfotables_pi1.php');
		// init class
		// code taken from the documentation
		self::$staticInfoObject = &t3lib_div::getUserObj('&tx_staticinfotables_pi1');
		if(!self::$staticInfoObject) {
			self::$staticInfoObject = false;
			return null;
		}
		if (self::$staticInfoObject->needsInit()) {
			self::$staticInfoObject->init();
		}
	}

}
?>