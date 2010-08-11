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
 * A class to enhance strtotime to use some more features that are available in PHP 5.3 in PHP 5.2
 * 
 * I decided not to support the full extend of PHP 5.3 functionality, but only the 
 * features that are needed most often.
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_StrToTime {
	
	/**
	 * a simple translation table for some non PHP 5.2 conform strings
	 * 
	 * @var array
	 */
	public static $translateTable52 = array(
		'first day of this month' => '%Y-%m-01 %H:%M:%S|',
		'first day of last month' => '%Y-%m-01 %H:%M:%S -1 month|',
		'first day of next month' => '%Y-%m-01 %H:%M:%S +1 month|',
		'last day of this month' => '%Y-%m-01 %H:%M:%S +1 month -1 day|',
		'last day of last month' => '%Y-%m-01 %H:%M:%S -1 day|',
		'last day of next month' => '%Y-%m-01 %H:%M:%S +2 months -1 day|',
		
//		'monday this week' => '%Y-W%V-1|',
//		'monday last week' => '%Y-W%V-1 -1 week|',
//		'monday next week' => '%Y-W%V-1 +1 week|',
//		'sunday this week' => '%Y-W%V-7|',
//		'sunday last week' => '%Y-W%V-7 -1 week|',
//		'sunday next week' => '%Y-W%V-7 +1 week|',
	);
	
	/**
	 * translates 3-lettered lowercased strings of a weekday to an integer
	 * 
	 * @var array
	 */
	public static $weekdayToInt = array(
		'mon' => 1,
		'tue' => 2,
		'wed' => 3,
		'thu' => 4,
		'fri' => 5,
		'sat' => 6,
		'sun' => 7
	);
	
	/**
	 * the enhanced strtotime()
	 * 
	 * * adds PHP 5.3 functionality to PHP 5.2
	 * * allows chaining of different phrases by using the pipe-symbol ("|")
	 * 
	 * @param string $time
	 * @param integer $now
	 */
	public static function strtotime($time, $now = null) {
		if(is_null($now)) {
			$now = time();
		}
		
		$time = self::doSubstitutions($time);
		
		foreach(t3lib_div::trimExplode('|', $time, true) as $time) {
			$now = strtotime(strftime($time, $now), $now);
		}
		
		return $now;
	}
	
	public static function doSubstitutions($time) {
		if(!self::isPHP53used()) {
			$time = self::doPHP52Substitutions($time);
		}
		
		return self::doCommonSubstitutions($time);
	}
	
	/**
	 * substitude PHP 5.3 phrases with PHP 5.2 compatible ones
	 * 
	 * @param string $time
	 * @param integer $now
	 */
	public static function doPHP52Substitutions($time) {
		return strtr($time, self::$translateTable52);
	}
	
	/**
	 * fix the fact that weeks in php start with sundays, but ISO weeks start with mondays
	 * 
	 * this would yield an inconsistency between PHP 5.2 and 5.3, as there would be no
	 * way to generate times of in the week format where sunday is the first day of the week
	 * 
	 * @param string $time
	 */
	public static function doCommonSubstitutions($time) {
		return preg_replace_callback(
			'/(mon(?:day)?|tue(?:sday)?|wed(?:nesday)?|thu(?:rsday)?|fri(?:day)?|sat(?:urday)?|sun(?:day)?) (last|this|next) week/i',
			array(self, 'callback_substitutedReltextWeekPattern'),
			$time
		);
	}
	
	/**
	 * callback for regexp in doCommonSubstitutions()
	 * 
	 * @see doCommonSubstitutions()
	 * @param string $matches
	 */
	protected static function callback_substitutedReltextWeekPattern($matches) {
		/**
		 * the day of the week as 3-letter lowercased string (like "mon", "tue")
		 * @var string
		 */
		$dow = strtolower(substr($matches[1], 0, 3));
		$whichWeek = $matches[2];
		
		$ret = '%G-W%V-'.self::$weekdayToInt[$dow];
		
		if($whichWeek === 'last') {
			$ret .= ' -1 week';
		} elseif ($whichWeek === 'next') {
			$ret .= ' +1 week';
		}
		
		return $ret;
	}
	
	/**
	 * cache variable to hold the info if PHP 5.3 is used
	 * 
	 * @var boolean
	 */
	protected static $isPHP53used = null;
	
	/**
	 * check if PHP 5.3 is used
	 * 
	 * @return boolean
	 */
	public static function isPHP53used() {
		if(is_null(self::$isPHP53used)) {
			self::$isPHP53used = version_compare(PHP_VERSION, '5.3.0') >= 0;
		}
		return self::$isPHP53used;
	}
	
}