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
 * A class to enhance strtotime to have some more features that are available in PHP 5.3
 * 
 * I decided not to support the full extend of PHP 5.3 functionality, but only the 
 * features that are needed most often.
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_StrToTime {
	
	public static $translateTable = array(
		'first day of this month' => '%Y-%m-01',
		'first day of last month' => '%Y-%m-01 -1 month',
		'first day of next month' => '%Y-%m-01 +1 month',
		'last day of this month' => '%Y-%m-01 +1 month -1 day',
		'last day of last month' => '%Y-%m-01 -1 day',
		'last day of next month' => '%Y-%m-01 +2 months -1 day',
		
		'first day of this week' => '%Y-W%V',
		'first day of last week' => '%Y-W%V -1 week',
		'first day of next week' => '%Y-W%V +1 week',
		'last day of this week' => '%Y-W%V +1 week -1 day',
		'last day of last week' => '%Y-W%V -1 day',
		'last day of next week' => '%Y-W%V +2 week -1 day',
	
		'first day of this year' => '%Y-01-01',
		'first day of last year' => '%Y-01-01 -1 year',
		'first day of next year' => '%Y-01-01 +1 year',
		'last day of this year' => '%Y-01-01 +1 year -1 day',
		'last day of last year' => '%Y-01-01 -1 day',
		'last day of next year' => '%Y-01-01 +2 years -1 day'
	);
	
	/**
	 * enhanced strtotime()
	 * 
	 * @param $time
	 * @param $now
	 * @return integer
	 */
	public static function strtotime($time, $now = null) {
		if(is_null($now)) {
			$now = time();
		}
		$time = strftime(strtr($time, self::$translateTable), $now);
		return strtotime($time, $now);
	}
}