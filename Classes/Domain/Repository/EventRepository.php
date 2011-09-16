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
 * Repository for Tx_CzSimpleCal_Domain_Model_Event
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_CzSimpleCal_Domain_Repository_EventRepository extends Tx_Extbase_Persistence_Repository {
	
	/**
	 * find a record by its uid regardless of its pid
	 * 
	 * @param $uid
	 * @return Tx_CzSimpleCal_Domain_Model_Event
	 */
	public function findOneByUidEverywhere($uid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		$query->setLimit(1);
		$query->matching($query->equals('uid',$uid));
		
		$result = $query->execute();
		if(count($result) < 1) {
			return null;
		}
		
		$object = $result->getFirst();
		$this->identityMap->registerObject($object, $uid);
		
		return $object;
	}
	
	/**
	 * find all records regardless of their storage page, enable fields or language
	 * 
	 * @return array <Tx_CzSimpleCal_Domain_Model_Event>
	 */
	public function findAllEverywhere() {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		
		return $query->execute();
	}
	
	/**
	 * find records for the indexing task
	 * with parameters suitable for the indexer
	 * 
	 * @param integer $limit
	 * @param integer $maxAge UNIX timestamp
	 */
	public function findRecordsForReindexing($limit = null, $maxAge = null) {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		if(!is_null($limit)) {
			$query->
				setLimit($limit)
			;
		}
		if(is_null($maxAge)) {
			// if: no maxAge is set, fetch the oldest events
			$query->setOrderings(array(
				'last_indexed' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING
			));
		} else {
			$query->matching(
				$query->lessThan('last_indexed', $maxAge)
			);
			/* no sorting here:
			 * - sorting would make the query slower
			 * - multiple parallel scheduler tasks could do the same work as there is no locking
			 *     with this "random" sorting, there is at least a chance this won't happen
			 */ 
		}
		return $query->execute();
	}
	
	/**
	 * make a given slug unique
	 * returns a unique slug
	 * 
	 * @param $slug
	 * @param $uid
	 * @return string
	 */
	public function makeSlugUnique($slug, $uid) {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		$query->matching($query->logicalAnd(
			$query->equals('slug', $slug),
			$query->logicalNot($query->equals('uid', $uid))
		));
		$count = $query->count();
		if($count !== false && $count == 0) {
			return $slug;
		} else {
			$query = $this->createQuery();
			$query->getQuerySettings()->
				setRespectStoragePage(false)->
				setRespectEnableFields(false)->
				setRespectSysLanguage(false)
			;
			$query->matching($query->logicalAnd(
				$query->like('slug', $slug.'-%'),
				$query->logicalNot($query->equals('uid', $uid))
			));
			$query->setOrderings(array(
				'slug' => Tx_Extbase_Persistence_QueryInterface::ORDER_DESCENDING
			));
			$query->setLimit(1);
			$result = $query->execute();
			
			if($result->count() == 0) {
				return $slug.'-1';
			} else {
				$number = intval(substr($result->getFirst()->getSlug(), strlen($slug) + 1)) + 1;
				return $slug.'-'.$number;
			}
		}
	}
	
	/**
	 * get the UNIX timestamp of the indexing of the oldest event that needs indexing
	 * 
	 * @return integer UNIX timestamp
	 */
	public function getMaxIndexAge() {
		$query = $this->createQuery();
		$query->getQuerySettings()->
			setRespectStoragePage(false)->
			setRespectEnableFields(false)->
			setRespectSysLanguage(false)
		;
		$query->setOrderings(array(
			'last_indexed' => Tx_Extbase_Persistence_Query::ORDER_ASCENDING
		));
		
		$query->setLimit(1);
		
		$result = $query->execute();
		
		if($result->count() == 0) {
			return null;
		} else {
			return $result->getFirst()->getLastIndexed()->format('U');
		}
	}
	
	/**
	 * find all events by a given user id
	 * @param string $userId
	 */
	public function findAllByUserId($userId) {
		if(!$userId) {
			return null;
		}
		
		$query = $this->createQuery();
		
		$query->matching($query->equals('cruser_fe', $userId));
		
		$query->setOrderings(array(
			'start_day' => Tx_Extbase_Persistence_Query::ORDER_DESCENDING
		));
				
		return $query->execute();
	}
	
}
?>