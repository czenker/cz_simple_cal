<?php
/**
 * removes lines from its content so it is suitable as a line for an ICS export
 */
class Tx_CzSimpleCal_ViewHelpers_Ics_OneLineViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	
	public function render() {
		$content = $this->renderChildren();
		
		return preg_replace('/[\s]+/', ' ', $content);
		
	}
}
?>