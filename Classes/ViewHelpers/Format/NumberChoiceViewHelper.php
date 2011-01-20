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
 * Renders a string based on a given number.
 * Usefull for localization of singular and plural and many other things
 * 
 * = text syntax = 
 * 
 * The syntax is identical to the format_number_choice() helper of symfony. 
 * And they took the class from the PRADO project.
 * If you are familiar with either there is nothing new to learn for you here.
 * 
 * 
 * 
 * The basic idea is to define intervals of numbers and a corresponding string to use.
 * Intervals are closed when using square brackets ("[" and "]") meaning, they include
 * the given number or open when using round brackets ("(" and ")") meaning, they exclude 
 * the given number.
 * 
 * Some examples:
 * * <code>[0]</code> would match 0.
 * * <code>[0,1]</code> would match 0 and 1.
 * * <code>[0,2)</code> would match 0 and 1, not 2.
 * * <code>[0,+Inf]</code> would match every non-negative number.
 * * <code>(0,+Inf]</code> would match every positive number.
 * * <code>[-Inf,+Inf]</code> would match any number
 * 
 * 
 * 
 * You can combine different conditions using the pipe "|".
 * The conditions are parsed from left to right using the first matching,
 * so your conditions won't have to be distinct, although it is considered
 * a good practice.
 * 
 * Some examples:
 * * <code>[0] no eggs|[1,+Inf] there are eggs</code>
 * * <code>[0] no eggs|[1,12) some eggs|[12] one dozen eggs|(12,+Inf]lots of eggs</code>
 * 
 * 
 * 
 * And of course you can use placeholders using the ###foobar### syntax.
 * 
 * An example:
 * * <code>[0] no eggs|[1] 1 egg|[2,+Inf] ###number### eggs</code>
 * 
 * Those placeholders are substituted with the settings used in "arguments".
 * 
 * = Examples =
 *
 * <code title="syntax simple">
 * <f:format.numberChoice text="[0] no eggs|[1,+Inf] eggs" number="0"/>
 * </code>
 * <output>
 * no eggs
 * </output>
 * 
 * <code title="syntax children">
 * <f:format.numberChoice number="1">[0] no eggs|[1,+Inf] eggs</f:format.numberChoice>
 * </code>
 * <output>
 * eggs
 * </output>
 * 
 * <code title="using placeholders">
 * <f:format.numberChoice number="42" arguments="{number:42}">[0] no eggs|[1] 1 egg|[2,+Inf] ###number### eggs</f:format.numberChoice>
 * </code>
 * <output>
 * 42 eggs
 * </output>
 * 
 * You can even use different intervals for different languages. If singular and plural
 * of a language are the same, you could join both.
 * 
 * <code title="using localization">
 * <f:format.numberChoice number="42" arguments="{number:42}"><f:translate key="foobar"></f:format.numberChoice>
 * </code>
 * <output>
 * 42 Eier
 * </output>
 * 
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Format_NumberChoiceViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	
	/**
	 * render a string based on a given number
	 * 
	 * @param integer  $number     the number that determines which text to use
	 * @param string   $text       the text configuration
	 * @param array    $arguments  values for the markers
	 * @return string Formatted string
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($number, $text = null, $arguments = array()) {
		if(is_null($text)) {
			$text = $this->renderChildren();
		}
		
		foreach($arguments as $key => $value) {
			$arguments[sprintf('###%s###', $key)] = $value;
			unset($arguments[$key]);
		}
		
		$formatter = new Tx_CzSimpleCal_ViewHelpers_Format_Contrib_ChoiceFormat();
		$ret = $formatter->format($text, $number);
		
		if($ret === false) {
			throw new InvalidArgumentException(sprintf('format.numberChoice could not parse the text "%s".', $text));
		}
		
		return strtr($ret, $arguments);
	}
}
?>