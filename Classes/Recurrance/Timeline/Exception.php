<?php 

/**
 *
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Recurrance_Timeline_Exception extends Tx_CzSimpleCal_Recurrance_Timeline_Base {

	/**
	 * (non-PHPdoc)
	 * @see Classes/Recurrance/Timeline/Tx_CzSimpleCal_Recurrance_Timeline_Base#add($data)
	 * @return Tx_CzSimpleCal_Recurrance_Timeline_Exception
	 */
	public function add($data) {
		try {
			parent::add($data);
		}
		catch(UnexpectedValueException $e) {
			// catched if an exception with this start-date already exists
			$key = $data['start'];
			if($this->data[$key]['end'] < $data['end']) {
				// if the set exception is shorter -> override it
				$this->data[$key] = $data;
			}
		}
		return $this;
	}
}