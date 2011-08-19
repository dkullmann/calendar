<?php
class Event extends CalendarAppModel {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = 'Event';

/**
 * Validation parameters - initialized in constructor
 *
 * @var array
 * @access public
 */
	public $validate = array();

/**
 * belongsTo association
 *
 * @var array $belongsTo 
 * @access public
 */
	public $belongsTo = array(
		'Calendar' => array(
			'className' => 'Calendar.Calendar',
			'foreignKey' => 'calendar_id',
		)
	);

	public $actsAs = array(
		'Calendar.RRule',
		'LocalizeTime.LocalizeTime' => array(
			'fields' => array('start_date', 'end_date')
		)
	);

/**
 * hasMany association
 *
 * @var array $hasMany
 * @access public
 */

	public $hasMany = array(
		'Attendee' => array(
			'className' => 'Calendar.Attendee',
			'foreignKey' => 'event_id',
			'dependent' => true
		)
	);


/**
 * Constructor
 *
 * @param mixed $id Model ID
 * @param string $table Table name
 * @param string $ds Datasource
 * @access public
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'calendar_id' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a Calendar', true))),
			'title' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a Title', true))),
			'time_zone' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a Time Zone', true))),
		);
		$this->utc_tz = new DateTimeZone('UTC');
	}

/**
 * Adds a new record to the database
 *
 * @param string $calendarId, Calendar id
 * @param array post data, should be Contoller->data
 * @return array
 * @access public
 */
	public function add($calendarId = null, $data = null, $frequency = null) {
		if (!empty($data)) {
			$data[$this->alias]['calendar_id'] = $calendarId;
			if (!empty($frequency) && !empty($data[$this->alias]['start_date'])) {
				$data['RRule'] = $this->buildRerurrenceByFrequency(
					$data[$this->alias]['start_date'],
					$data[$this->alias]['time_zone'],
					$frequency
				);
			}
			if (!empty($data['RRule'])) {
			    $data[$this->alias]['recurring'] = true;
			}

			$this->create();
			$this->set($data);
			$this->serializeRules();
			$result = $this->saveAll($this->data);
			if ($result !== false) {
				return true;
			} else {
				throw new OutOfBoundsException(__('Could not save the event, please check your inputs.', true));
			}
			return $return;
		}
	}

/**
 * Edits an existing Event.
 *
 * @param string $id, event id 
 * @param string $user, event owner id
 * @param array $data, controller post data usually $this->data
 * @param string $frequency, if set it will be taken as the default recurrence frequency for the event
 * deleting all existing recurrence rules on database for the event
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit($id = null, $user = null, $data = null, $frequency = null) {
		$event = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				"Calendar.user_id" => $user,
			),
			'contain' => array('Calendar')
		));

		if (empty($event)) {
			throw new OutOfBoundsException(__('Invalid Event', true));
		}
		$this->set($event);

		if (!empty($data)) {
			$this->set($data);

			if ($frequency) {
				$this->RRule->deleteAll(array('event_id' => $id));
				$this->data['RRule'] = $this->buildRerurrenceByFrequency(
					$this->data[$this->alias]['start_date'],
					$this->data[$this->alias]['time_zone'],
					$frequency
				);
				$this->data[$this->alias]['recurring'] = true;
				$this->serializeRules();
			}

			$result = $this->saveAll($this->data);
			if ($result) {
				return true;
			} else {
				return $data;
			}
		} else {
			return $event;
		}
	}

/**
 * Returns the record of a Event.
 *
 * @param string $id, event id.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function view($id = null) {
		$event = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id)));

		if (empty($event)) {
			throw new OutOfBoundsException(__('Invalid Event', true));
		}

		return $event;
	}

/**
 * Validates the deletion
 *
 * @param string $id, event id 
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function validateAndDelete($id = null, $user, $data = array()) {
		$event = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				'Calendar.user_id' => $user
			),
			'contain' => array('Calendar')
		));

		if (empty($event)) {
			throw new OutOfBoundsException(__('Invalid Event', true));
		}

		$this->data['event'] = $event;
		if (!empty($data)) {
			$data[$this->alias]['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data[$this->alias]['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Event', true));
		}
	}

/**
 * Called before each save operation, after validation. Return a non-true result
 * to halt the save. Converts times to UTC before saving them in the database.
 *
 * @return boolean True if the operation should continue, false if it should abort
 * @access public
 * @link http://book.cakephp.org/view/1048/Callback-Methods#beforeSave-1052
 */
	public function beforeSave($options = array()) {
		// All of this is done by LocalizeTime.LocalizeTime now
		// if (
		// 	!empty($this->data[$this->alias]['time_zone']) &&
		// 	!empty($this->data[$this->alias]['start_date']) &&
		// 	!empty($this->data[$this->alias]['end_date'])
		// ) {
		// 	$user_tz = new DateTimeZone($this->data[$this->alias]['time_zone']);
		// 	$this->data[$this->alias]['start_date'] = CalendarDate::convertToUTC($this->data[$this->alias]['start_date'], $user_tz);
		// 	$this->data[$this->alias]['end_date']   = CalendarDate::convertToUTC($this->data[$this->alias]['end_date'], $user_tz);
		// }
		return true;
	}

/**
 * afterFind() creates recurring events from results set
 *
 * @param array $results The results from the find operation
 * @param bool $primary true if this is the primary model for the find operation
 * @return array Modified results set
 * @access public
 */
 	/* TODO: There may be more logic required if we are not the primary model. */
	public function afterFind($results, $primary) {
		if ($this->findQueryType == 'count') {
		    return $results;
		}

		$results = $this->_calculateRecurrence($results, $primary);
		$results = $this->_calculateAvailability($results, $primary);
		$results = $this->_doLocalizeTimeAfterFind($results, $primary);
		return parent::afterFind($results, $primary);
	}
	
	protected function _calculateRecurrence($results, $primary) {
		if (!$this->Behaviors->attached('RRule')) {
			return $results;
		} else {
			return $this->calculateRecurrence($results, $primary);
		}
	}
	
	protected function _calculateAvailability($results, $primary) {
		if (!$this->Behaviors->attached('AvailabilityCalculator')) {
			return $results;
		} else {
			return $this->calculateAvailability($results, $primary);
		}
	}
	
	protected function _doLocalizeTimeAfterFind($results, $primary) {
		if (!$this->Behaviors->attached('LocalizeTime')) {
			return $results;
		} else {
			return $this->doLocalizeTimeAfterFind($results, $primary);
		}
	}

}
