<?php 

/**
 * an extension of the DateTime object
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_DateTime extends DateTime {
	
	public function __construct($dateTime) {
		parent::__construct($this->substitudeStrftimeMarkers($dateTime));
	}
	
	public function setTime ($time) {
		parent::setTime($this->substitudeStrftimeMarkers($time));
	}

	public function setDate ($date) {
		parent::setDate($this->substitudeStrftimeMarkers($date));
	}

	public function setISODate ($date) {
		parent::setISODate($this->substitudeStrftimeMarkers($date));
	}

	public function getTimestamp() {
		return $this->format('U');
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
	protected function substitudeStrftimeMarkers($get, $timestamp = null) {
		if(is_null($timestamp)) {
			$timestamp = time();
		}
		
		//escape all alpha numeric signs, as they are almost all reserved by date()
		$get = preg_replace('/(?<!%)[[:alpha:]]/', '\\\\$0', $get);
		
		//substitude strftime()-markers with date()-markers
		$get = strtr($get, self::$strftimeToDate);
		
		//parse it
		return date($get, $timestamp);
	}
	
}