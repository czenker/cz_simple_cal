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
	
	/**
	 * find all records and return them ordered by the start date ascending
	 * 
	 * @return array
	 */
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
		$query = $this->setupSettings($settings);
		
		return $query->execute();
	}
	
	/**
	 * find all events matching some settings and count them
	 * 
	 * for all options for the settings see setupSettings()
	 * 
	 * @see setupSettings()
	 * @see doCountAllWithSettings()
	 * @param $settings
	 * @return array
	 */
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
			} elseif($settings['groupBy'] === 'year') {
				$step = '+1 year';
			} else {
				$step = null;
			}
			
			$startDate = new Tx_CzSimpleCal_Utility_DateTime('@'.$settings['startDate']);
			$startDate->setTimezone(new DateTimeZone(date_default_timezone_get()));
			
			$endDate = $settings['endDate'];
			while ($startDate->getTimestamp() < $endDate) {
				if($step === null) {
					$tempEndDate = null;
				} else {
					$tempEndDate = clone $startDate;
					$tempEndDate->modify($step.' -1 second');
				}
				
				$output[] = array(
					'date' => $startDate->format('c'),
					'count' => $this->doCountAllWithSettings(array_merge(
						$settings,
						array(
							'startDate' => $startDate->format('U'),
							'endDate' => $tempEndDate ? $tempEndDate->format('U') : null,
							'groupBy' => null 
						)
					))
				);
				
				if($step === null) {
					break;
				} else {
					$startDate->modify($step);
				}
			}
			
			return $output;
		}
		
	}
	
	/**
	 * setup settings for an query
	 * 
	 * possible restrictions are:
	 * 
	 *  * startDate             integer timestamp of the start
	 *  * endDate               integer timestamp of the end
	 *  * order                 string  the mode to sort by (could be 'asc' or 'desc')
	 *  * orderBy               string  the field to sort by (could be 'start' or 'end')
	 *  * maxEvents             integer the maximum of events to return
	 *  * includeStartedEvents  boolean if events that were in progress on the startDate should be shown
	 *  * excludeOverlongEvents boolean if events that were not yet finished on the endDate should be excluded
	 *  * filter                array   key is field name and value the desired value, multiple filters are concated with "AND"
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
		if(isset($settings['filter'])) {
			foreach($settings['filter'] as $name => $filter) {
				if(is_array($filter['value'])) {
					$temp_constraint = $query->in('event.'.$name, $filter['value']);
					
					if(isset($filter['negate']) && $filter['negate']) {
						$temp_constraint = $query->logicalNot($temp_constraint);
					}
					
					if(isset($constraint)) {
						$constraint = $query->logicalAnd($constraint, $temp_constraint);
					} else {
						$constraint = $temp_constraint;
					}
				}
				// @todo: support for atomic values
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
	
	/**
	 * filter settings for all allowed properties for setupSettings()
	 * 
	 * @var array
	 */
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
		'filter' => array(
			'filter' => FILTER_UNSAFE_RAW, // this is treated seperately
			'flags' => FILTER_FORCE_ARRAY
		),
	);
	
	/**
	 * do the cleaning of the values so that no wrong variable type or value will be used
	 * 
	 * @param $settings
	 * @return array 
	 */
	protected function cleanSettings($settings) {

		// unset unknown fields 
		$settings = array_intersect_key($settings, self::$filterSettings);
		
		$settings = filter_var_array($settings, self::$filterSettings);
		
		
		if(isset($settings['filter'])) {
			$settings['filter'] = $this->setupFilters($settings['filter']);
		}
		
		return $settings;
	}
	
	/**
	 * sanitize the "order" setting
	 * 
	 * @param $value
	 * @return string|null
	 */
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
	
	/**
	 * sanitize something to be a valid string
	 * (only ASCII letters, numbers, ".", "_" and "-")
	 * 
	 * @param $value
	 */
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
	
	/**
	 * sanitizing the value for the "filter" setting.
	 * If multiple values are given return an array
	 * 
	 * @param $filter
	 */
	protected static function sanitizeFilter($filter) {
		$out = array();
		
		if(!is_array($filter)) {
			$filter = array(
				'value' => t3lib_div::trimExplode(',', $filter, true) 
			);
		} elseif(!empty($filter['_typoScriptNodeValue']) && !is_array($filter['_typoScriptNodeValue'])) {
			/* this field is set if something like
			 *     filter {
			 *         foo = bar
			 *         foo.negate = 1
			 *     }
			 * was set in the frontend
			 * 
			 * This is processed prior to the value field, so 
			 * that a flexform is able to override it.
			 * 
			 * @see Tx_Extbase_Utility_TypoScript
			 */
			$filter['value'] = t3lib_div::trimExplode(',', $filter['_typoScriptNodeValue'], true);
			unset($filter['_typoScriptNodeValue']);
		} elseif(!empty($filter['value']) && !is_array($filter['value'])) {
			$filter['value'] = t3lib_div::trimExplode(',', $filter['value'], true);
		}
		
		foreach($filter['value'] as &$value) {
			if(is_numeric($value)) {
				$value = intval($value);
			}
		}
		return empty($filter['value']) ? null : $filter;
	}
	
	/**
	 * sanitizing the given filters
	 * 
	 * @param $filters
	 * @param $prefix
	 * @return array
	 */
	protected function setupFilters($filters, $prefix = '') {
		if(!is_array($filters)) {
			return null;
		}
		
		$return = array();
		
		foreach($filters as $name => $filter) {
			if($this->isFilter($filter)) {
				$cleanedFilter = self::sanitizeFilter($filter);
				if(!is_null($cleanedFilter)) {
					$return[$prefix.$name] = $cleanedFilter;
				}
			} else {
				if(is_array($filter)) {
					$return = array_merge(
						$return, 
						$this->setupFilters($filter, $prefix.$name.'.')
					);
				}
			}
		}
		return $return;
	}
	
	/**
	 * check if a given value is a filter
	 * 
	 * @param mixed $filter
	 */
	protected function isFilter($filter) {
		return !is_array($filter) || array_key_exists('negate', $filter) || array_key_exists('value', $filter);
	}
	
	/**
	 * make a given slug unique among all records
	 * 
	 * @param $slug
	 * @param $uid
	 * @return string the unique slug
	 */
	public function makeSlugUnique($slug, $uid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		$query->matching($query->logicalAnd(
			$query->equals('slug', $slug),
			$query->logicalNot($query->equals('uid', $uid))
		));
		$count = $query->count();
		if($count !== false && $count == 0) {
			return $slug;
		} else {
			$query = $this->createQuery();
			$query->getQuerySettings()->
				setRespectStoragePage(false)->
				setRespectEnableFields(false)->
				setRespectSysLanguage(false)
			;
			$query->matching($query->logicalAnd(
				$query->like('slug', $slug.'-%'),
				$query->logicalNot($query->equals('uid', $uid))
			));
			$query->setOrderings(array(
				'slug' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
			));
			$query->setLimit(1);
			$result = $query->execute();
			
			if($result->count() === 0) {
				return $slug.'-1';
			} else {
				$number = intval(substr($result->getFirst()->getSlug(), strlen($slug) + 1)) + 1;
				return $slug.'-'.$number;
			}
		}
	}
	
	/**
	 * call an event before adding an event to the repo
	 * 
	 * @see Classes/Persistence/Tx_Extbase_Persistence_Repository::add()
	 */
	public function add($object) {
		$object->preCreate();
		parent::add($object);
	}
	
	/**
	 * get a list of upcomming appointments by an event uid
	 * 
	 * @param integer $eventUid
	 * @param integer $limit
	 */
	public function findNextAppointmentsByEventUid($eventUid, $limit = 3) {
		$query = $this->createQuery();
		$query->setLimit($limit);
		$query->matching($query->logicalAnd(
			$query->equals('event.uid', $eventUid),
			$query->greaterThanOrEqual('start', time())
		));
		$query->setOrderings(array('start' => Tx_Extbase_Persistence_QueryInterface::ORDER_ASCENDING));
		
		return $query->execute();
	}
}
?>