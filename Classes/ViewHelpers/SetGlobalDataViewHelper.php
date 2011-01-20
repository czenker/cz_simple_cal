<?php
/*                                                                        *
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
 * sets data of the global cObject
 * 
 * you can utilize this to set the <title>-tag or other <head> data
 * 
 * as page.headerData is generated after generating the content of the page
 * you can override some fields or create new ones
 * 
 * <example>
 *   <code>
 *     <cal:setGlobalData field="title">{event.title}</cal:setGlobalData>
 *   </code>
 *   
 *   <code>
 *     page.headerData {
 *       10 = TEXT
 *       10.field = title
 *       10.wrap = <title>|</title>
 *     }
 *   </code>
 *   
 *   will output the events title as the pages title
 *   
 * </example>
 * 
 * or a less "hackier" example
 * 
 * <example>
 *   <code>
 *     <cal:setGlobalData field="override_title" data="{event.title}" />
 *   </code>
 *   
 *   <code>
 *     page.headerData {
 *       10 = TEXT
 *       10.field = override_title // title
 *       10.wrap = <title>|</title>
 *     }
 *   </code>
 * </example>
 *
 * @author Christian Zenker <christian.zenker@599media.de>
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_CzSimpleCal_ViewHelpers_SetGlobalDataViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param string $field the field name to override or create
	 * @param string $data the data to add to the field
	 * @return null
	 */
	public function render($field, $data = null) {
		if(is_null($data)) {
			$data = $this->renderChildren();
		}
		$GLOBALS['TSFE']->cObj->data[$field] = $data;
	}
}

?>