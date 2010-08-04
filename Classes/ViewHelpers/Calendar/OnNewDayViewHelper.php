<?php
/**
 * stupidly simple - just do nothing
 */
class Tx_CzSimpleCal_ViewHelpers_Calendar_OnNewDayViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	protected $className = 'Tx_CzSimpleCal_ViewHelpers_Variable_InitViewHelper';
	
	/**
	 * 
	 * @param Tx_CzSimpleCal_Domain_Model_EventIndexer $event
	 * @param string $label if you need multiple irrelated instances set this to something unique
	 * @return string
	 */
	public function render($event, $label = '') {
		
		if (!$this->viewHelperVariableContainer->exists($this->className, 'container')) {
			throw new LogicException(sprintf('%s should be used inside %s.', get_class($this), $this->className));
		}
		
		$name = 'last_day_wrapper_date';
		if($label) {
			$name.='_'.$label;
		}
		
		$container = $this->viewHelperVariableContainer->get($this->className, 'container');
		
		$lastDay = $container->exists($name) ?
			 $container->get($name) :
			 0
		;
		$thisDay = strtotime('midnight', $event->getStart());
		
		if($thisDay == $lastDay) {
			return '';
		}
		
		$container->set($name, $thisDay);
		
		return $this->renderChildren();
	}
}
?>