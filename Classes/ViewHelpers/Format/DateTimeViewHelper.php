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
 * 
 * <code title="Defaults with string">
 * <cal:format.dateTime timestamp="2009-02-13 20:31:30GMT" />
 * </code>
 *
 * Output:
 * 2009-02-13
 * 
 *
 * <code title="Defaults with DateTime object">
 * <cal:format.dateTime timestamp="dateTimeObject" />
 * </code>
 *
 * Output:
 * 2009-02-13
 * 
 * 
 * <code title="Custom date format">
 * <cal:format.dateTime format="%a, %e. %B %G" timestamp="1234567890" />
 * </code>
 *
 * Output:
 * Fre, 13. Februar 2009
 * (for german localization)
 *
 *
 * <code title="relative date">
 * <cal:format.dateTime timestamp="1234567890" get="+1 day"/>
 * </code>
 *
 * Output:
 * 2009-02-14
 * 
 *
 * <code title="relative date">
 * <cal:format.dateTime timestamp="1234567890" get="first of this month"/>
 * </code>
 *
 * Output:
 * 2009-02-01
 * 
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @see http://www.php.net/manual/en/function.strftime.php
 * @see http://www.php.net/manual/en/function.strtotime.php
 * @see http://www.php.net/manual/en/datetime.formats.relative.php
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Format_DateTimeViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Render the supplied unix timestamp in a localized human-readable string.
	 *
	 * @param integer|string|DateTime $timestamp unix timestamp, a DateTime object or type "date"
	 * @param string $format Formatting string to be parsed by strftime
	 * @param string $get get some related date (see class doc)
	 * @return string Formatted date
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($timestamp = NULL, $format = '%Y-%m-%d', $get = '') {
		
		$timestamp = $this->normalizeTimestamp($timestamp);
		if($get) {
			$timestamp = $this->modifyDate($timestamp, $get);
		}
		return strftime($format, $timestamp);
	}
	
	/**
	 * handle all the different input formats and return a real timestamp
	 * 
	 * @param $timestamp
	 * @return integer
	 */
	protected function normalizeTimestamp($timestamp) {
		if(is_null($timestamp)) {
			$timestamp = time();
		} elseif(is_numeric($timestamp)) {
			$timestamp = intval($timestamp);
		} elseif(is_string($timestamp)) {
			$timestamp = Tx_CzSimpleCal_Utility_StrToTime::strtotime($timestamp);
		} elseif($timestamp instanceof DateTime) {
			$timestamp = $timestamp->format('U');
		} else {
			throw new InvalidArgumentException(sprintf('timestamp might be an integer, a string or a DateTimeObject only.'));
		}
		return $timestamp;
	}
	
	/**
	 * do the modification to a relative date
	 * 
	 * @param $timestamp
	 * @param $get
	 * @return string
	 */
	protected function modifyDate($timestamp, $get) {
		return Tx_CzSimpleCal_Utility_StrToTime::strtotime($get, $timestamp);
	}
}
?>