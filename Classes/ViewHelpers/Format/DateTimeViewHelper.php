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
 * Formats a unix timestamp to a human-readable, localized string
 *
 * = Examples =
 *
 * <code title="Defaults">
 * <cal:format.dateTime timestamp="1234567890" />
 * </code>
 *
 * Output:
 * 2009-02-13
 *
 * <code title="Custom date format">
 * <cal:format.dateTime format="%a, %e. %B %G" timestamp="1234567890" />
 * </code>
 *
 * Output:
 * Fre, 13. Februar 2009
 * (for german localization)
 *
 * <code title="relative date">
 * <cal:format.dateTime timestamp="1234567890" get="+1 day"/>
 * </code>
 *
 * Output:
 * 2009-02-14
 *
 * <code title="relative date with substitution">
 * <cal:format.dateTime timestamp="1234567890" get="%B %G next month -1 second"/>
 * </code>
 *
 * Output:
 * 2009-02-28
 * 
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Format_DateTimeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Render the supplied unix timestamp in a localized human-readable string.
	 *
	 * @param integer $timestamp unix timestamp
	 * @param string $get get some related date (see class doc)
	 * @param string $format Format String to be parsed by strftime
	 * @return string Formatted date
	 * @see http://www.php.net/manual/en/function.strftime.php
	 * @see http://www.php.net/manual/en/function.strtotime.php
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($timestamp = NULL, $get = '', $format = '%Y-%m-%d') {
		
		if(is_null($timestamp)) {
			$timestamp = time();
		}
		
		if(!empty($get)) {
			
			$get = $this->parseGet($get, $timestamp);
			
			$timestamp = strtotime($get, $timestamp);
			if($timestamp === false) {
				throw new InvalidArgumentException(sprintf('Don\'t know, what you mean by "%s".', $get));
			}
		}
		
		return strftime($format, $timestamp);
	}
	
	/**
	 * translation table from strftime() to date() format
	 * 
	 * @var array
	 * @author <baptiste dot place at utopiaweb dot fr>
	 * @see http://www.php.net/manual/en/function.strftime.php#96424
	 */
	protected static $strftimeToDate = array(
		// Day - no strf eq : S 
        '%d' => 'd', '%a' => 'D', '%e' => 'j', '%A' => 'l', '%u' => 'N', '%w' => 'w', '%j' => 'z', 
        // Week - no date eq : %U, %W 
        '%V' => 'W',  
        // Month - no strf eq : n, t 
        '%B' => 'F', '%m' => 'm', '%b' => 'M', 
        // Year - no strf eq : L; no date eq : %C, %g 
        '%G' => 'o', '%Y' => 'Y', '%y' => 'y', 
        // Time - no strf eq : B, G, u; no date eq : %r, %R, %T, %X 
        '%P' => 'a', '%p' => 'A', '%l' => 'g', '%I' => 'h', '%H' => 'H', '%M' => 'i', '%S' => '%s', 
        // Timezone - no strf eq : e, I, P, Z 
        '%z' => 'O', '%Z' => 'T', 
        // Full Date / Time - no strf eq : c, r; no date eq : %c, %D, %F, %x  
        '%s' => 'U'
		
	);
	
	/**
	 * translate strftime()-syntax to date()-syntax and substitude
	 * 
	 * @param string $get
	 * @return string
	 */
	protected function parseGet($get, $timestamp) {
		//escape all alpha numeric signs, as they are almost all reserved by date()
		$get = preg_replace('/(?<!%)[[:alpha:]]/', '\\\\$0', $get);
		
		//substitude strftime()-markers with date()-markers
		$get = strtr($get, self::$strftimeToDate);
		
		//parse it
		return date($get, $timestamp);
	}
}
?>