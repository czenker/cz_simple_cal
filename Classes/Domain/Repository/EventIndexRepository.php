<?php
/***************************************************************
*  Copyright notice
*
*  (c)  TODO - INSERT COPYRIGHT
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Repository for Tx_CzSimpleCal_Domain_Model_EventIndex
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Repository_EventIndexRepository extends Tx_Extbase_Persistence_Repository {
	
	public function findAll() {
		$query = $this->createQuery();
		$query->setOrderings(array('start' => 'ASC'));
		return $query->execute();
	}
	
	/**
	 * find all events matching some settings
	 * 
	 * for all options for the settings see setupSettings()
	 * 
	 * @see setupSettings()
	 * @param $settings
	 * @return array
	 */
	public function findAllWithSettings($settings = array()) {
		$settings = $this->cleanSettings($settings);
		$query = $this->setupSettings($this->cleanSettings($settings));
		
		return $query->execute();
	}
	
	public function countAllWithSettings($settings = array()) {
		$settings = $this->cleanSettings($settings);
		return $this->doCountAllWithSettings($settings);
	}
	
	/**
	 * find all events matching some settings and count them
	 * 
	 * @param $settings
	 * @ugly doing dozens of database requests
	 * @return array
	 */
	protected function doCountAllWithSettings($settings = array()) {
		if(!isset($settings['groupBy'])) {
			return $this->setupSettings($settings)->count();
		} else {
			$output = array();
			if($settings['groupBy'] === 'day') {
				$step = '+1 day';
			} elseif($settings['groupBy'] === 'week') {
				$step = '+1 week';
			} elseif($settings['groupBy'] === 'month') {
				$step = '+1 month';
			} else {
				$step = '+1 year';
			}
			
			$startDate = new Tx_CzSimpleCal_Utility_DateTime('@'.$settings['startDate']);
			$startDate->setTimezone(new DateTimeZone(date_default_timezone_get()));
			
			$endDate = $settings['endDate'];
			while ($startDate->getTimestamp() < $endDate) {
				$tempEndDate = clone $startDate;
				$tempEndDate->modify($step.' -1 second');
				
				$output[] = array(
					'date' => $startDate->format('c'),
					'count' => $this->doCountAllWithSettings(array_merge(
						$settings,
						array(
							'startDate' => $startDate->format('U'),
							'endDate' => $tempEndDate->format('U'),
							'groupBy' => null 
						)
					))
				);
				
				$startDate->modify($step);
			}
			
			return $output;
		}
		
	}
	
	/**
	 * setup settings for an query
	 * 
	 * possible restrictions are:
	 * 
	 *  * startDate integer timestamp of the start
	 *  * endDate   integer timestamp of the end
	 *  * limit     integer how many events to select at max
	 *  * order     string  the mode to sort by (could be 'asc' or 'desc')
	 *  * orderBy   string  the field to sort by (could be 'start' or 'end')
	 * 
	 * all given values must be sanitized
	 * 
	 * @param array $settings
	 * @param $query
	 * @ugly extbase query needs a better fluent interface for query creation
	 * @return Tx_Extbase_Persistence_Query
	 */
	protected function setupSettings($settings = array(), $query = null) {
		if(is_null($query)) {
			$query = $this->createQuery();
		}
		
		// startDate
		if(isset($settings['startDate'])) {
			$constraint = $query->greaterThanOrEqual($settings['includeStartedEvents'] ? 'end' : 'start', $settings['startDate']);
		}
		// endDate
		if(isset($settings['endDate'])) {
			$temp_constraint = $query->lessThanOrEqual($settings['excludeOverlongEvents'] ? 'end' : 'start', $settings['endDate']);
			 
			if(isset($constraint)) {
				$constraint = $query->logicalAnd($constraint, $temp_constraint);
			} else {
				$constraint = $temp_constraint;
			}
		}
		
		// filterCategories
		if(isset($settings['filterCategories'])) {
			$temp_constraint = $query->in('event.category', $settings['filterCategories']);
			
			if(isset($constraint)) {
				$constraint = $query->logicalAnd($constraint, $temp_constraint);
			} else {
				$constraint = $temp_constraint;
			}
		}
		
		// all constraints should be gathered here
		
		// set the WHERE part
		if(isset($constraint)) {
			$query->matching($constraint);
		}
		
		// limit
		if(isset($settings['maxEvents'])) {
			$query->setLimit(intval($settings['maxEvents']));
		}
		
		// order and orderBy
		if(isset($settings['order']) || isset($settings['orderBy'])) {
			if(!isset($settings['orderBy'])) {
				$orderBy = 'start';
			} elseif($settings['orderBy'] === 'start' || $settings['orderBy'] === 'startDate') {
				$orderBy = 'start';
			} elseif($settings['orderBy'] === 'end' || $settings['orderBy'] === 'endDate') {
				$orderBy = 'end';
			} else {
				throw new InvalidArgumentException('"orderBy" should be one of "start" or "end".');
			}
			
			if(!isset($settings['order'])) {
				$order = Tx_Extbase_Persistence_Query::ORDER_ASCENDING;
			} elseif(strtolower($settings['order']) === 'asc') {
				$order = Tx_Extbase_Persistence_Query::ORDER_ASCENDING;
			} elseif(strtolower($settings['order']) === 'desc') {
				$order = Tx_Extbase_Persistence_Query::ORDER_DESCENDING;
			} else {
				throw new InvalidArgumentException('"order" should be one of "asc" or "desc".');
			}
			
			$query->setOrderings(array($orderBy => $order));
		}
		
		return $query;
	}
	
	protected static $filterSettings = array(
		'startDate' => array(
			'filter' => FILTER_VALIDATE_INT,
			'options' => array('min_range' => 0, 'default' => null)
		),
		'endDate' => array(
			'filter' => FILTER_VALIDATE_INT,
			'options' => array('min_range' => 0, 'default' => null)
		),
		'maxEvents'     => array(
			'filter' => FILTER_VALIDATE_INT,
			'options' => array(
				'min_range' => 1,
				'default' => null
			),
		),
		'order'     =>  array(
			'filter' => FILTER_CALLBACK,
			'options' => array(self, 'sanitizeOrder')
		),
		'orderBy'   => array(
			'filter' => FILTER_CALLBACK,
			'options' => array(self, 'sanitizeString'),
		),
		'filterCategories' => array(
			'filter' => FILTER_UNSAFE_RAW, // this is treated seperately
			'flags' => FILTER_FORCE_ARRAY
		),
		'groupBy'   => array(
			'filter' => FILTER_CALLBACK,
			'options' => array(self, 'sanitizeString'),
		),
		'includeStartedEvents' => array(
			'filter' => FILTER_VALIDATE_BOOLEAN
		),
		'excludeOverlongEvents' => array(
			'filter' => FILTER_VALIDATE_BOOLEAN,
		),
	);
	
	protected function cleanSettings($settings) {

		// unset unknown fields 
		$settings = array_intersect_key($settings, self::$filterSettings);
		
		$settings = filter_var_array($settings, self::$filterSettings);
		$settings['filterCategories'] = self::sanitizeFilterCategories(
			isset($settings['filterCategories'][1]) ? $settings['filterCategories'] : $settings['filterCategories'][0]
		);
		
		return $settings;
	}
	
	protected static function sanitizeOrder($value) {
		if(!is_string($value)) {
			return null;
		}
		$value = strtolower($value);
		if($value === 'desc') {
			return 'desc';
		} elseif($value === 'asc') {
			return 'asc';
		}
		return null;
	}
	
	protected static function sanitizeString($value) {
		$value = trim($value);
		if(!is_string($value) || empty($value)) {
			return null;
		}
		if(preg_match('/[^a-z0-9\._\-]/i', trim($value))) {
			// if: there is anything not a letter, number, dot, underscore or hyphen
			return null;
		} else {
			return $value;
		}
	}
	
	protected static function sanitizeFilterCategories($array) {
		if(!is_array($array)) {
			$array = t3lib_div::trimExplode(',', $array, true);
		}
		$out = array();
		
		foreach($array as $value) {
			if(is_numeric($value)) {
				$out[] = intval($value);
			}
		}
		return empty($out) ? null : $out;
	}
	
	
}
?>