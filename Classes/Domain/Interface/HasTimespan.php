<?php 

/**
 * this interface meens this domain model has a start and an end time
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
interface Tx_CzSimpleCal_Domain_Interface_HasTimespan {
	
	/**
	 * get the start of this domain model
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectStart();
	
	/**
	 * get the end of this domain model
	 * 
	 * @return Tx_CzSimpleCal_Utility_DateTime
	 */
	public function getDateTimeObjectEnd();
	
}