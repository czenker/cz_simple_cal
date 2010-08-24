<?php 

/**
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Utility_FlexConfig {

	public function getAllowedActions($config) {
		$pid = $config['row']['pid'];
		$tsConfig = t3lib_befunc::getPagesTSconfig($pid);
		
		$flexConfig = &$tsConfig['options.']['cz_simple_cal_pi1.']['flexform.'];
		
		if(empty($flexConfig) || !isset($flexConfig['allowedActions.'])) {
			return;
		}
		
		$allowedActions = array();
		if(isset($flexConfig['allowedActions'])) {
			$enabled = array();
			foreach(t3lib_div::trimExplode(',', $flexConfig['allowedActions'], true) as $i) {
				$enabled[$i.'.'] = '';
			}
			$allowedActions = array_intersect_key($flexConfig['allowedActions.'], $enabled);
		} else {
			$allowedActions = $flexConfig['allowedActions.'];
		}
		
		foreach($allowedActions as $name => $action) {
			$name = rtrim($name, '.');
			$label = $GLOBALS['LANG']->sL($action['label']);
			if(empty($label)) {
				$label = $name;
			}
			$config['items'][$name] = array(
				$label,
				$name
			);
		}
	}
	
}