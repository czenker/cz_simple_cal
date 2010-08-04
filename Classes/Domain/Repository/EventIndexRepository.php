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
		$query = $this->setupSettings($settings);
		
		return $query->execute();
	}
	
	/**
	 * find all events matching some settings and count them
	 * 
	 * @param $settings
	 * @ugly doing dozens of database requests
	 * @return unknown_type
	 */
	public function countAllWithSettings($settings = array()) {
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
			
			$startDate = clone $settings['startDate'];
			$endDate = $settings['endDate']->getTimestamp();
			
			while ($startDate->getTimestamp() < $endDate) {
				$tempEndDate = clone $startDate;
				$tempEndDate->modify($step.' -1 second');
				
				$output[] = array(
					'date' => $startDate->format('Y-m-d H:i:s'),
					'count' => $this->countAllWithSettings(array_merge(
						$settings,
						array(
							'startDate' => $startDate,
							'endDate' => $tempEndDate,
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
	 * @param $settings
	 * @ugly extbase query needs a better fluent interface for query creation
	 * @return Tx_Extbase_Persistence_Query
	 */
	protected function setupSettings($settings = array(), $query = null) {
		if(is_null($query)) {
			$query = $this->createQuery();
		}
		
		// startDate
		if(isset($settings['startDate'])) {
			$constraint = $query->greaterThanOrEqual('start', $settings['startDate']->getTimestamp());
		}
		// endDate
		if(isset($settings['endDate'])) {
			$temp_constraint = $query->lessThanOrEqual('end', $settings['endDate']->getTimestamp());
			 
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
		if(isset($settings['limit'])) {
			$query->setLimit(intval($settings['limit']));
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
}
?>