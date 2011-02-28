<?php 

/**
 * the scheduler task to index all events
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_Scheduler_Index extends tx_scheduler_Task implements tx_scheduler_AdditionalFieldProvider {
	
	/**
	 * @var Tx_CzSimpleCal_Indexer_Event
	 */
	protected $indexer = null;
	
	/**
	 * @var Tx_Extbase_Persistence_ManagerInterface
	 */
	protected $persistenceManager = null;
	
	/**
	 * @var Tx_CzSimpleCal_Domain_Repository_EventRepository
	 */
	protected $eventRepository = null;
	
	/**
	 * the max_execution_time of PHP in seconds
	 * 
	 * this is used to guess if an other cycle would run into this limit and abort earlier
	 * 
	 * @var integer
	 */
	protected $maxExecutionTime = null;
	/**
	 * the memory_limit of PHP in bytes
	 * 
	 * this is used to guess if an other cycle would run into this limit and abort earlier
	 * 
	 * @var integer
	 */
	protected $memoryLimit = null;
	
	/**
	 * the number of records to fetch at a time before persisting
	 * 
	 * (might be configurable later on) 
	 * 
	 * @var integer 
	 */
	protected $chunkSize = 50;
	
	/**
	 * event will be reindexed if the last indexing is older than that
	 * 
	 * will be parsed through Tx_CzSimpleCal_Utility_StrToTime
	 * 
	 * @var string
	 */
	public $minIndexAge = '-1 month'; // public for tx_scheduler_AdditionalFieldProvider interface
	
	
	protected $minIndexAgeAbsolute = null;
	
	/**
	 * init some needed objects and variables
	 */
	protected function init() {
		$objectManager = t3lib_div::makeInstance('Tx_Extbase_Object_ObjectManager');
		
		$this->eventRepository = $objectManager->get('Tx_CzSimpleCal_Domain_Repository_EventRepository');
		$this->indexer = $objectManager->get('Tx_CzSimpleCal_Indexer_Event');
		$this->persistenceManager = $objectManager->get('Tx_Extbase_Persistence_ManagerInterface'); 
		
		
		try {
			$this->maxExecutionTime = intval(ini_get('max_execution_time'));
		}
		catch(Exception $e) {}
		if(!$this->maxExecutionTime || $this->maxExecutionTime < 5) {
			// if value could not be determined or it seems faulty
			$this->maxExecutionTime = 30;
		}
		
		try {
			$memoryLimit = ini_get('memory_limit');
			$this->memoryLimit = t3lib_div::getBytesFromSizeMeasurement($memoryLimit);
		}
		catch(Exception $e) {}
		if(!$this->memoryLimit || $this->memoryLimit < 0x2000000) {
			// if value could not be determined or it seems faulty
			$this->memoryLimit = 0x2000000; // =32M
		}
		
		$this->minIndexAgeAbsolute = $this->minIndexAge ? 
			Tx_CzSimpleCal_Utility_StrToTime::strtotime($this->minIndexAge) :
			null 
		;
		
	}
	
	
	/**
	 * execute this task
	 * 
	 * @return boolean
	 */
	public function execute() {
		
		$this->init();
		
		while($this->shouldAnotherChunkBeProcessed()) {
			$events = $this->eventRepository->findRecordsForReindexing($this->chunkSize, $this->minIndexAgeAbsolute);
			if(!$events->count() > 0) {
				// if: there is nothing more to do
				return true;
			}
			$this->indexEvents($events);
		}
		
		// if: the script stopped, but not all data could be processed
		
		if($GLOBALS['LANG']) {
			$message = t3lib_div::makeInstance(
			    't3lib_FlashMessage',
				sprintf(
					'cz_simple_cal (uid: %d): %s',
					 $this->getTaskUid(),
					 sprintf(
					 	$GLOBALS['LANG']->sL('LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.info_index_not_finished'),
					 	date('c', $this->eventRepository->getMaxIndexAge())
					 )
				),
			    '',
			    t3lib_FlashMessage::INFO
			);
			t3lib_FlashMessageQueue::addMessage($message);
		}
		
		return true;
	}	
	
	/**
	 * the maximum execution time used for indexing one previous chunk
	 * 
	 * @var float
	 */
	protected $maxChunkDuration = null;
	
	/**
	 * the maximum added memory usage used for one previous chunk
	 * 
	 * @var integer
	 */
	protected $maxChunkMemoryIncrease = null;
	
	/**
	 * microtime of the start of the last loop
	 * 
	 * @var float
	 */
	protected $lastStart = null;
	
	/**
	 * memory consumption before starting the last loop
	 * 
	 * @var unknown_type
	 */
	protected $lastMemory = null;
	
	/**
	 * the time where the script is thought to end
	 * 
	 * this is very, very vague and usually more strict then reality
	 * for example calls to the database are not taken into account by PHP
	 * 
	 * @var float
	 */
	protected $endOfScriptTime = null;
	
	/**
	 * a factor that determines how carefull
	 * the decision if to run another loop should be made
	 * 
	 * the higher the value, the earlier the script will abort
	 * 
	 * @var float
	 */
	const FACTOR_FOR_LOOP_DETERMINATION = 1.5;
	
	/**
	 * the logic to determine if another loop of indexing
	 * a chunk of events should be done or not
	 * 
	 * This logic was added so that the script won't run out of time or memory 
	 * and remain in an uncertain state.
	 * Having a fixed number of events to process did not seem to be a good solution
	 * as events with lots of recurrances are usually more time consuming than 
	 * simple events without recurrance.
	 * 
	 * @return boolean
	 */
	protected function shouldAnotherChunkBeProcessed() {
		if(is_null($this->lastStart) || is_null($this->lastMemory)) {
			//if: this is the first loop -> init some values
			$this->lastStart = microtime(true);
			$this->lastMemory = memory_get_peak_usage();
			
			$this->endOfScriptTime = $this->lastStart - 1 + $this->maxExecutionTime;
			// always do at least one loop
			return true;
		} else {
			$microtime = microtime(true);
			$memory_get_peak_usage = memory_get_peak_usage();
			
			
			// update the max* values if they have changed
			$duration = $microtime - $this->lastStart;
			if($duration > $this->maxChunkDuration) {
				$this->maxChunkDuration = $duration;
			}
			$memoryIncrease = $memory_get_peak_usage - $this->lastMemory;
			if($memoryIncrease > $this->maxChunkMemoryIncrease) {
				$this->maxChunkMemoryIncrease = $memoryIncrease;
			}
			
			// check if another loop should be done
			if($this->endOfScriptTime < $microtime + self::FACTOR_FOR_LOOP_DETERMINATION * $this->maxChunkDuration) {
				//if: the script might take too long
				return false;
			}
			elseif($this->memoryLimit < $memory_get_peak_usage + self::FACTOR_FOR_LOOP_DETERMINATION * $this->maxChunkMemoryIncrease) {
				//if: memory usage might explode
				return false;
			}
			
			$this->lastStart = $microtime;
			$this->lastMemory = $memory_get_peak_usage;
			return true;
		}
	}
	
	
	/**
	 * one (of likely many) loops of processing a given
	 * chunk of events 
	 * 
	 * @param $events
	 */
	protected function indexEvents($events) {
		foreach($events as $event) {
			$this->indexer->update($event);
		}
		
		$this->persistenceManager->persistAll();
	}
	
/*
 * 
 * implement the tx_scheduler_AdditionalFieldProvider interface
 * 
 * 
 */	

	/**
	 * Gets additional fields to render in the form to add/edit a task
	 *
	 * @param	array					Values of the fields from the add/edit task form
	 * @param	tx_scheduler_Task		The task object being eddited. Null when adding a task!
	 * @param	tx_scheduler_Module		Reference to the scheduler backend module
	 * @return	array					A two dimensional array, array('Identifier' => array('fieldId' => array('code' => '', 'label' => '', 'cshKey' => '', 'cshLabel' => ''))
	 */
	public function getAdditionalFields(array &$taskInfo, $task, tx_scheduler_Module $schedulerModule) {
		$additionalFields = array();
		
		if (empty($taskInfo['tx_czsimplecal_minindexage'])) {
			if ($schedulerModule->CMD == 'add') {
				$taskInfo['tx_czsimplecal_minindexage'] = $this->minIndexAge; // $task will be null at this point
			} elseif ($schedulerModule->CMD == 'edit') {
				$taskInfo['tx_czsimplecal_minindexage'] = $task->minIndexAge;
			} else {
				$taskInfo['tx_czsimplecal_minindexage'] = '';
			}
		}

			// Write the code for the field
		$fieldCode = sprintf(
			'<input type="text" name="tx_scheduler[tx_czsimplecal_minindexage]" id="tx_czsimplecal_minindexage" value="%s" size="30" />',
			htmlspecialchars($taskInfo['tx_czsimplecal_minindexage'])
		);
		$additionalFields[$fieldId] = array(
			'code'     => $fieldCode,
			'label'    => 'LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.minindexage.label',
			'cshKey'   => '',
			'cshLabel' => 'tx_czsimplecal_minindexage'
		);
		
		return $additionalFields;
	}

	/**
	 * Validates the additional fields' values
	 *
	 * @param	array					An array containing the data submitted by the add/edit task form
	 * @param	tx_scheduler_Module		Reference to the scheduler backend module
	 * @return	boolean					True if validation was ok (or selected class is not relevant), false otherwise
	 */
	public function validateAdditionalFields(array &$submittedData, tx_scheduler_Module $schedulerModule) {
		if(empty($submittedData['tx_czsimplecal_minindexage'])) {
			$submittedData['tx_czsimplecal_minindexage'] = null;
		} elseif(!is_string($submittedData['tx_czsimplecal_minindexage'])) {
			$schedulerModule->addMessage(
				$GLOBALS['LANG']->sL('LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.minindexage.nostring'),
				t3lib_FlashMessage::ERROR
			);
			return false;
		} else {
			if(Tx_CzSimpleCal_Utility_StrToTime::strtotime($submittedData['tx_czsimplecal_minindexage']) === false) {
				$schedulerModule->addMessage(
					sprintf(
						$GLOBALS['LANG']->sL('LLL:EXT:cz_simple_cal/Resources/Private/Language/locallang_mod.xml:tx_czsimplecal_scheduler_index.minindexage.parseerror'),
						$submittedData['tx_czsimplecal_minindexage']
					),
					t3lib_FlashMessage::ERROR
				);
				return false;
			}
		}
		return true;
	}

	/**
	 * Takes care of saving the additional fields' values in the task's object
	 *
	 * @param	array					An array containing the data submitted by the add/edit task form
	 * @param	tx_scheduler_Task		Reference to the scheduler backend module
	 * @return	void
	 */
	public function saveAdditionalFields(array $submittedData, tx_scheduler_Task $task){
		$task->minIndexAge = $submittedData['tx_czsimplecal_minindexage'];
	}
	
	
	
}