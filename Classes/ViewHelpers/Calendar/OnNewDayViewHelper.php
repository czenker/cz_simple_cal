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
 * renders its content if the submitted event is on a different date then the previous one
 * 
 * <example>
 * <f:for each="{events}" as="event">
 *   <cal:calendar.onNewDay event="{event}">
 *     Good morning. This is a new day.
 *   </cal:calendar.onNewDay>
 *   {event.title}
 * </f:for>
 * </example>
 *  
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Calendar_OnNewDayViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	/**
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_EventIndexer $event the event to compare to the previously submitted one
	 * @param string $label if you need multiple irrelated instances set this to something unique
	 * @return string
	 */
	public function render($event, $label = '') {
		
		$className = get_class($this);
		
		$name = 'last_day_wrapper_date';
		if($label) {
			$name.='_'.$label;
		}
		
		if ($this->viewHelperVariableContainer->exists($className, $name)) {
			$lastDay = $this->viewHelperVariableContainer->get($className, $name);
		} else {
			
		}
		
		$thisDay = strtotime('midnight', $event->getStart());
		
		if($thisDay == $lastDay) {
			return '';
		} else {
			$this->viewHelperVariableContainer->addOrUpdate($className, $name, $thisDay);
			return $this->renderChildren();
		}
	}
}
?>