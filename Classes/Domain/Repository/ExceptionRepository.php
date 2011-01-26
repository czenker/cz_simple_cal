<?php
/***************************************************************
*  Copyright notice
*
*  (c)  TODO - INSERT COPYRIGHT
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
 * Repository for Tx_CzSimpleCal_Domain_Model_Exception
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Repository_ExceptionRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * find all exceptions for an event
	 * 
	 * @param integer $uid event_id
	 * @ugly support for joins in extbase misses some features. It seems as if MM_opposite_field won't get any attention when building queries.
	 * @return array
	 */
	public function findAllForEventId($uid) {
		
		$query = $this->createQuery();
		
		$query->statement('
			SELECT DISTINCT tx_czsimplecal_domain_model_exception.* 
			FROM tx_czsimplecal_domain_model_exception
			JOIN tx_czsimplecal_event_exception_mm ON tx_czsimplecal_domain_model_exception.uid = tx_czsimplecal_event_exception_mm.uid_foreign
			WHERE
				tx_czsimplecal_event_exception_mm.tablenames = "tx_czsimplecal_domain_model_exception"
				AND tx_czsimplecal_event_exception_mm.uid_local = ?
		', array($uid));
		$exceptions = $query->execute();
		
		
		// second: get all exceptions that are linked via ExceptionGroups
		$query = $this->createQuery();
		
		$query->statement('
			SELECT DISTINCT tx_czsimplecal_domain_model_exception.* 
			FROM tx_czsimplecal_domain_model_exception
			JOIN tx_czsimplecal_exceptiongroup_exception_mm ON tx_czsimplecal_exceptiongroup_exception_mm.uid_foreign = tx_czsimplecal_domain_model_exception.uid
			JOIN tx_czsimplecal_event_exception_mm ON tx_czsimplecal_event_exception_mm.uid_foreign = tx_czsimplecal_exceptiongroup_exception_mm.uid_local
			WHERE
				tx_czsimplecal_event_exception_mm.tablenames = "tx_czsimplecal_domain_model_exceptiongroup"
				AND tx_czsimplecal_event_exception_mm.uid_local = ?
		', array($uid));
		$exceptions2 = $query->execute();
		
		// merge it return it
		//TODO: check for duplicates
		return array_merge(
			$exceptions->toArray(),
			$exceptions2->toArray()
		);
	}
}
?>