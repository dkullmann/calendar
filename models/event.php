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
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
/**
 * hasMany association
 *
 * @var array $hasMany
 * @access public
 */

	public $hasMany = array(
		'RecurrenceRule' => array(
			'className' => 'Calendar.RecurrenceRule',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
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
	public function add($calendarId = null, $data = null) {
		if (!empty($data)) {
			$data['Event']['calendar_id'] = $calendarId;
			if (!empty($data['RecurrenceRule'])) {
			    $data['Event']['recurring'] = true;
			}
			$this->create();
			$result = $this->saveAll($data);
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
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit($id = null, $data = null) {
		$event = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($event)) {
			throw new OutOfBoundsException(__('Invalid Event', true));
		}
		$this->set($event);

		if (!empty($data)) {
			$this->set($data);
			$result = $this->save(null, true);
			if ($result) {
				$this->data = $result;
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
	public function validateAndDelete($id = null, $data = array()) {
		$event = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($event)) {
			throw new OutOfBoundsException(__('Invalid Event', true));
		}

		$this->data['event'] = $event;
		if (!empty($data)) {
			$data['Event']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['Event']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Event', true));
		}
	}

/**
 * Renders a recurring event for the given date. Does not check to make sure the
 * event occurs on this date (use RecurrenceRule::ruleIsTrue for that).
 *
 * @param array $event Contains data formatted the same as a retrieved Event from a find.
 * @param DateTime $date A DateTime object in UTC time. This is the date to render the event for.
 * @return array The instance rendered for this recurring event
 * @access public
 */
	public function renderEventForDate($event, $date) {

		$rendered_event = $event;

		$user_tz = new DateTimeZone($event[$this->alias]['time_zone']);

		$start_date = new CalendarDate($event[$this->alias]['start_date']);
		$end_date   = new CalendarDate($event[$this->alias]['end_date']);

		$interval = $start_date->diff($end_date);
		$interval = new DateInterval("PT{$interval->h}H{$interval->i}M");

		$start_date->setTimezone($user_tz);

		$floating_start_hour = $start_date->format('H');

		$date->setTimezone($user_tz);
		$date->setTime($floating_start_hour, $date->format('i'), $date->format('s'));
		$date->setTimezone($this->utc_tz);
		$event[$this->alias]['start_date'] = $date->format();

		$date->add($interval);
		$event[$this->alias]['end_date'] = $date->format();

		return $event;

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
		$user_tz = new DateTimeZone($this->data[$this->alias]['time_zone']);

		$this->data[$this->alias]['start_date'] = CalendarDate::convertToUTC($this->data[$this->alias]['start_date'], $user_tz);
		$this->data[$this->alias]['end_date']   = CalendarDate::convertToUTC($this->data[$this->alias]['end_date'], $user_tz);

		return true;
	}

/**
 * beforeFind() saves the start and end time given to the find operation
 * so that recurring events can be calculated in afterFind
 *
 * @param mixed $query Query data based in from find method
 * @return mixed $query Query data
 * @access public
 */

 	/* TODO: We should make a $query parameter 'recurring' to use here */
	public function beforeFind($query) {
		if(!empty($query['conditions']['start_date']) && !empty($query['conditions']['end_date'])) {
			$this->_recurrenceStart = $query['conditions']['start_date'];
			$this->_recurrenceEnd = $query['conditions']['end_date'];

			$query['conditions']['OR'] = array(
					"AND" => array (
						"Event.end_date >" => $query['conditions']['start_date'],
						"Event.start_date <" => $query['conditions']['end_date'],
					),
					"Event.recurring" => true,
				);

			unset($query['conditions']['start_date']);
			unset($query['conditions']['end_date']);
		}

		return $query;
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
		$events = array();
		if (empty($this->_recurrenceStart) || empty($this->_recurrenceEnd)) {
		    return $results;
		}

		foreach ($results as $event) {
			if (isset($event['RecurrenceRule']) && count($event['RecurrenceRule']) >= 1) {

				$oneDay = new DateInterval('P1D');
				$end_day = new CalendarDate($this->_recurrenceEnd);

				for ($date = new CalendarDate($this->_recurrenceStart); $date <= $end_day; $date->add($oneDay)) {
					foreach ($event['RecurrenceRule'] as $rule) {
						if ($this->RecurrenceRule->ruleIsTrue($rule, $date)) {
							$events[] = $this->renderEventForDate($event, clone $date);
						}
					}
				}
			} else {
				$events[] = $event;
			}
		}
        $this->_recurrenceStart = $this->_recurrenceEnd = null;
		return parent::afterFind($events, $primary);
	}
}