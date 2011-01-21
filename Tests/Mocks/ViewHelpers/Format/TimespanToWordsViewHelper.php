<?php 

require_once t3lib_extMgm::extPath('cz_simple_cal').'Classes/ViewHelpers/Format/TimespanToWordsViewHelper.php';

class Tx_CzSimpleCalTests_Mock_ViewHelpers_Format_TimespanToWordsViewHelper extends Tx_CzSimpleCal_ViewHelpers_Format_TimespanToWordsViewHelper {
	
	protected $ll = array(
		"timespan.format.sameDay" =>'%B %e, %Y',
		"timespan.format.sameMonth.start" => '%B %e',
		"timespan.format.sameMonth.end" => '%e, %Y',
		"timespan.format.sameYear.start" => '%B %e',
		"timespan.format.sameYear.end" => '%B %e, %Y',
		"timespan.format.else.start" => '%B %e, %Y',
		"timespan.format.else.end" => '%B %e, %Y',
		"timespan.from" => 'from',
		"timespan.to" => 'to',
		"timespan.on" => 'on',
	);
	
	protected function getLL($key) {
		return $this->ll[$key];
	}
}
