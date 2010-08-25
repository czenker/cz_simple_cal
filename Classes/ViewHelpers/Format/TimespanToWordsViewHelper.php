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
 * 
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Format_TimespanToWordsViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Render the supplied unix timestamp in a localized human-readable string.
	 *
	 * @param Tx_CzSimpleCal_Utility_DateTime $start
	 * @param Tx_CzSimpleCal_Utility_DateTime $end
	 * @return string Formatted output
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($start, $end) {
		$this->extensionName = $this->controllerContext->getRequest()->getControllerExtensionName();
		
		if($start->format('Y') != $end->format('Y')) {
			return
				$this->getLL('timespan.from').' '.
				strftime($this->getLL('timespan.format.else.start'), $start->getTimestamp()).' '.
				$this->getLL('timespan.to').' '.
				strftime($this->getLL('timespan.format.else.end'), $end->getTimestamp())
			;
		} elseif($start->format('m') != $end->format('m')) {
			return
				$this->getLL('timespan.from').' '.
				strftime($this->getLL('timespan.format.sameYear.start'), $start->getTimestamp()).' '.
				$this->getLL('timespan.to').' '.
				strftime($this->getLL('timespan.format.sameYear.end'), $end->getTimestamp())
			;
		} elseif($start->format('d') != $end->format('d')) {
			return
				$this->getLL('timespan.from').' '.
				strftime($this->getLL('timespan.format.sameMonth.start'), $start->getTimestamp()).' '.
				$this->getLL('timespan.to').' '.
				strftime($this->getLL('timespan.format.sameMonth.end'), $end->getTimestamp())
			;
		} else {
			return
				$this->getLL('timespan.on').' '.
				strftime($this->getLL('timespan.format.sameDay'), $start->getTimestamp())
			;
		}
		
	}
	
	protected $extensionName = null;
	
	protected function getLL($key) {
		return Tx_Extbase_Utility_Localization::translate($key, $this->extensionName);
	}
	
}
?>