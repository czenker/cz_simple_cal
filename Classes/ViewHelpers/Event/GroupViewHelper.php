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
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Event_GroupViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * 
	 * @param array $events the events
	 * @param string $as the variable name the group events should be written to
	 * @param string $by one of the supported types
	 * @param string $orderBy
	 * @param string $order
	 * @return string
	 */
	public function render($events, $as, $by = 'day', $orderBy = '', $order='') {
		$by = strtolower($by);
		if($by === 'day') {
			$events = $this->groupByTime($events, 'midnight');
		} elseif($by === 'month') {
			$events = $this->groupByTime($events, 'first day of this month midnight');
		} elseif($by === 'year') {
			$events = $this->groupByTime($events, 'january 1st midnight');
		} elseif($by === 'location') {
			$events = $this->groupByLocation($events);
		} elseif($by === 'organizer') {
			$events = $this->groupByOrganzier($events);
		} else {
			throw new InvalidArgumentException(sprintf('%s can\'t group by "%s". Maybe a misspelling?', get_class($this), $by));
		}
		
		$this->templateVariableContainer->add($as, $events);
			$output = $this->renderChildren();
		$this->templateVariableContainer->remove($as);
		
		return $output;
	}
	
	/**
	 * do grouping by some time related constraint
	 * 
	 * @param Tx_Extbase_Persistence_QueryResultInterface $events
	 * @param string $string
	 * @return array
	 */
	protected function groupByTime($events, $string) {
		$result = array();
		foreach($events as $event) {
			$key = Tx_CzSimpleCal_Utility_StrToTime::strtotime($string, $event->getStart());
			if(!array_key_exists($key, $result)) {
				$result[$key] = array(
					'info' => $key,
					'events' => array(),
				);
			}
			
			$result[$key]['events'][] = $event;
		}
		return $result;
	}
	
	/**
	 * do grouping by location
	 * 
	 * @param $events
	 */
	protected function groupByLocation($events) {
		$result = array();
		foreach($events as $event) {
			$locationKey = $event->getLocation() ? $event->getLocation()->getUid() : 0;
			if(!array_key_exists($locationKey, $result)) {
				$result[$locationKey] = array(
					'info' => $event->getLocation() ? $event->getLocation() : false,
					'events' => array(),
				);
			}
			
			$result[$locationKey]['events'][] = $event;
		}
		return $this->order($result);
	}
	
	/**
	 * do grouping by organizer
	 * 
	 * @param $events
	 */
	protected function groupByOrganizer($events) {
		$result = array();
		foreach($events as $event) {
			$organizerKey = $event->getOrganizer() ? $event->getOrganizer()->getUid() : 0;
			if(!array_key_exists($locationKey, $result)) {
				$result[$organizerKey] = array(
					'info' => $event->getOrganizer() ? $event->getOrganizer() : false,
					'events' => array(),
				);
			}
			
			$result[$organizerKey]['events'][] = $event;
		}
		return $this->order($result);
	}
	
	protected function order($events) {
		if(!$this->arguments['orderBy'] && !$this->arguments['order']) {
			return $events;
		} elseif($this->arguments['orderBy']) {
			$this->orderGetMethodName = 'get'.t3lib_div::underscoredToUpperCamelCase($this->arguments['orderBy']);
			if(usort($events, array($this, "orderByObjectMethod"))) {
				return $events;
			} else {
				throw new RuntimeException(sprintf('%s could not sort the events.', get_class($this)));
			}
		}
	}
	
	protected $orderGetMethodName = null;
	
	protected function orderByObjectMethod($a, $b) {
		if(strlen($this->orderGetMethodName) < 5) {
			throw new UnexpectedValueException(sprintf('%s was called without setting a getMethodName', __FUNCTION__, $code));
		}
		
		$aValue = call_user_func(array($a['info'], $this->orderGetMethodName));
		$bValue = call_user_func(array($b['info'], $this->orderGetMethodName));
		
		return $aValue < $bValue ? -1 : ($aValue > $bValue ? 1 : 0);
	}
}
?>