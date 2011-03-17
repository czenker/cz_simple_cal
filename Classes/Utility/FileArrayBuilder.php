<?php

/***************************************************************
*  Copyright notice
*
*  (c) 2010 Christian Zenker <christian.zenker@599media.de>, 599media GmbH
*  			
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * builds an array of file instances from a list of filenames, a path name, alternate texts and captions
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Utility_FileArrayBuilder {
	
	/**
	 * build an array of image instances
	 * 
	 * @param string|array $files string should use "," as seperator
	 * @param string $path
	 * @param string|array $alternateTexts string should use newline as seperator
	 * @param string|array $captions string should use newline as seperator
	 * @return array<Tx_CzEwlSponsor_Domain_Model_File>
	 */
	public static function build($files, $path, $alternates = '', $captions = '') {
		$return = array();
		
		if(!is_array($files)) {
			$files = is_string($files) && !empty($files) ? t3lib_div::trimExplode(",", $files, false) : array();
		}
		
		if(!is_array($alternates)) {
			$alternates = is_string($alternates) && !empty($alternates) ? t3lib_div::trimExplode("\n", $alternates, false) : array();
		}
		
		if(!is_array($captions)) {
			$captions =  is_string($captions) && !empty($captions) ? t3lib_div::trimExplode("\n", $captions, false) : array();	
		}
		
		if($path && substr($path, -1) !== '/') {
			$path = $path.'/';
		}
		
		foreach($files as $key=>$fileName) {
			if(empty($fileName)) {
				continue;
			}
			$file = new Tx_CzSimpleCal_Domain_Model_File();
			$file->setPath($path);
			$file->setFile($fileName);
			if(array_key_exists($key, $captions) && $captions[$key]) {
				$file->setCaption($captions[$key]);
			}
			if(array_key_exists($key, $alternates) && $alternates[$key]) {
				$file->setAlternateText($alternates[$key]);
			}
			$return[] = $file; 
		}
		
		return $return;
	}
	
}