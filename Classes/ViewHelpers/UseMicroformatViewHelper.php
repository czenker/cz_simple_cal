<?php
/**
 * adds a microformat to the head definition
 */
class Tx_CzSimpleCal_ViewHelpers_UseMicroformatViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	protected static $knownMicroformats = array(
		'hcard' => 'http://microformats.org/profile/hcard',
		'hcalendar' => 'http://microformats.org/profile/hcalendar'
	);
	
	/**
	 * add a microformat definition to the pages head
	 * 
	 * @param string $format you might give the uri of the microformat or use the predefined strings "hcard" or "hcalendar"
	 */
	public function render($format) {
		if(array_key_exists($format, self::$knownMicroformats)) {
			$format = self::$knownMicroformats[$format];
		}
		
		$name = get_class($this).'-'.base64_encode($format);
		$GLOBALS['TSFE']->additionalHeaderData[$name] = sprintf(
			'<link rel="profile" href="%s">',
			$format
		);
	}
}
?>