<?php 

class Tx_CzSimpleCal_Indexer_Event extends Tx_CzSimpleCal_Indexer_Base {
	
	static private
		$eventTable = 'tx_czsimplecal_domain_model_event',
		$eventIndexTable = 'tx_czsimplecal_domain_model_eventindex'
	;
	
	protected
		$id = null,
		$fieldsArray = null,
		$update = null
	;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventRepository
	 */
	protected $eventRepository = null;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventIndexRepository
	 */
	protected $eventIndexRepository = null;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Model_Event
	 */
	protected $model = null;
	
	
	/**
	 * main function that is called by the hook
	 * 
	 * @see Classes/Indexer/Tx_CzSimpleCal_Indexer_Base#index($id, $fieldsArray, $update)
	 */
	public function index($id, $fieldsArray, $update = true) {
		$this->id = intval($id);
		$this->fieldsArray = $fieldsArray;
		$this->update = $update;
		
		if(!$update || $this->eventWasChanged()) {
			// re-index if event is new or it was changed in a way that requires re-indexing
			
			$this->doIndex();
		}
	}
	
	/**
	 * checks if the event was changed in a way, that re-indexing is required
	 * 
	 * @return boolean
	 */
	protected function eventWasChanged() {
		return $this->haveFieldsChanged(array(
			'recurrance_type',
			'recurrance_until',
			'recurrance_times',
			'start_date',
			'start_time',
			'end_date',
			'end_time',
			'pid'
		));
	}
	
	/**
	 * do the actual indexing
	 * 
	 * @return void
	 */
	protected function doIndex() {
		$this->init();
		
		if($this->update) {
			// delete all indexed events
			$GLOBALS['TYPO3_DB']->exec_DELETEquery(
				self::$eventIndexTable,
				'event = '.$this->id
			);
		}
		
		// get all recurrances...
		foreach($this->model->getRecurrances() as $recurrance) {
			// ...and store them to the repository
			$instance = Tx_CzSimpleCal_Domain_Model_EventIndex::fromArray(
				$recurrance
			);
			
			
			$this->eventIndexRepository->add(
				$instance
			);
			
		}
		
		Tx_Extbase_Dispatcher::getPersistenceManager()->persistAll();
		
	}
	
	/**
	 * initialize repositories and models
	 * 
	 * @return void
	 */
	protected function init() {
		/**
		 * @var Tx_Extbase_Dispatcher
		 */
		t3lib_div::makeInstance('Tx_Extbase_Dispatcher');
		
		$this->eventRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$this->eventIndexRepository = t3lib_div::makeInstance('Tx_CzSimpleCal_Domain_Repository_EventIndexRepository');
		$this->model = $this->eventRepository->findOneByUidEverywhere($this->id);
		
		if(is_null($this->model)) {
			throw new RuntimeException(sprintf('The %s with the uid %d could not be found.', self::$eventTable, $this->id));
		}
	}	
}