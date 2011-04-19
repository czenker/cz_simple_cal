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
	 * @param Tx_Extbase_Persistence_QueryResultInterface $events the events
	 * @param string $as the variable name the group events should be written to
	 * @param string $by one of the supported types
	 * @return string
	 */
	public function render($events, $as, $by = 'day') {
		$by = strtolower($by);
		if($by === 'day') {
			$events = $this->groupByTime($events, 'midnight');
		} elseif($by === 'month') {
			$events = $this->groupByTime($events, 'first day of this month midnight');
		} elseif($by === 'year') {
			$events = $this->groupByTime($events, 'january 1st midnight');
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
}
?>