<?php

/*           DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *                  Version 2, December 2004
 *
 * Copyright (C) 2010 Christian Zenker <christian.zenker@599media.de>
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 *         DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 * TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 * 
 * 0. You just DO WHAT THE FUCK YOU WANT TO.
 */

/**
 * A view helper to do a mathematical comparison on two values.
 * 
 * This view helper is best used in conjunction with the ifViewHelper.
 * 
 * These are the operators that might be used: 
 * 
 * 	* "=" or "=="    check if both values are equal (integer 10 would be equal to string "10")
 *  * "==="          check if both values are identical (integer 10 would NOT be equal to string "10")
 *  * "!=" or "<>"   check if both values are not equal
 *  * "!=="          do an additional type check
 *  * ">"            check if the first value is larger than the second one
 *  * ">=" or "=>"   check if the first value is larger or equal than the second one
 *  * "<"            check if the first value is smaller than the second one
 *  * "<=" or "=<"   check if the first value is smaller or equal than the second one 
 *  
 * <code title="basic example">
 *      <f:if condition="{x:condition.compare(value1: 10, value2: 10)}">Both values are equal</f:if>
 * </code>
 *  
 * Condition would evaluate to true as "=" is the default comparison.
 * 
 * 	
 * <code title="integer vs string 1">
 *      <f:if condition="{x:condition.compare(value1: 10, value2: '10', operation:'=')}">Both values are equal</f:if>
 * </code>
 *  
 * Condition would evaluate to true as "=" does not do a type check.
 * 
 *  
 * <code title="integer vs string 2">
 *     <f:if condition="{x:condition.compare(value1: 10, value2: '10', operation:'===')}">Both values are equal</f:if>
 * </code>
 *  
 * Condition would evaluate to false as "===" does a type check.
 *  
 *  
 * <code title="comparing strings">
 *     <f:if condition="{x:condition.compare(value1: 'foo', value2: 'foo')}">Both values are equal</f:if>
 * </code>  
 * 
 * Condition would evaluate to true as both strings are equal.
 * 
 *
 * <code title="comparing object method results">
 *     <f:if condition="{x:condition.compare(value1: person.age, value2: 18, operation='&lt;')}">You are too young</f:if>
 * </code>  
 *   
 * @license WTFPL, Version 2
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_ViewHelpers_Condition_CompareViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * Compare two values
	 *
	 * @param mixed $value1 first value
	 * @param mixed $value2 second value
	 * @param string $operation a string for the operation
	 * @return boolean if the condition is met
	 * @author Christian Zenker <christian.zenker@599media.de>
	 */
	public function render($value1, $value2, $operation = '=') {
		$operation = htmlspecialchars_decode($operation);
		
		if($operation === '=' || $operation === '==') {
			return $value1 == $value2;
		} elseif($operation === '===') {
			return $value1 === $value2;
		} elseif($operation === '!=' || $operation === '<>') {
			return $value1 != $value2;
		} elseif($operation === '!==') {
			return $value1 !== $value2;
		} elseif($operation === '>') {
			return $value1 > $value2;
		} elseif($operation === '>=' || $operation === '=>') {
			return $value1 >= $value2;
		} elseif($operation === '<') {
			return $value1 < $value2;
		} elseif($operation === '<=' || $operation === '=<') {
			return $value1 <= $value2;
		} else {
			throw new InvalidArgumentException(sprintf('The operation "%s" is unknown. Please see the documentation for valid values.', $operation));
		}
	}
}
?>