<?php 

/**
 * this interface meens this domain model could be recurring
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
interface Tx_CzSimpleCal_Domain_Interface_IsRecurring extends Tx_CzSimpleCal_Domain_Interface_HasTimespan {
	
	public function getRecurranceType();
	
	public function setRecurranceType($recurranceType);
	
	public function getRecurranceUntil();
	
	public function getDateTimeObjectRecurranceUntil();
	
	public function setRecurranceUntil($recurranceUntil);
	
	public function getRecurranceWeeklyInterval();
	
	public function setRecurranceWeeklyInterval($recurranceWeeklyInterval);
	
}