<?php
class RecurrenceRule extends CalendarAppModel {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = 'RecurrenceRule';

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
		'Event' => array(
			'className' => 'Calendar.Event',
			'foreignKey' => 'event_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
			'frequency' => array(
				'allowedChoice' => array(
					'rule' => array('inList', array('daily','weekly','monthly','yearly')),
					'message' => __('Recurrence must be daily, weekly, monthly, or yearly', true),
				),
			),
		);
	}

/**
 * Adds a new record to the database
 *
 * @param array post data, should be Contoller->data
 * @return array
 * @access public
 */
	public function add($data = null) {
		if (!empty($data)) {
			$this->create();
			$result = $this->save($data);
			if ($result !== false) {
				$this->data = array_merge($data, $result);
				return true;
			} else {
				throw new OutOfBoundsException(__('Could not save the recurrenceRule, please check your inputs.', true));
			}
			return $return;
		}
	}

/**
 * Edits an existing Recurrence Rule.
 *
 * @param string $id, recurrence rule id 
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit($id = null, $data = null) {
		$recurrenceRule = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($recurrenceRule)) {
			throw new OutOfBoundsException(__('Invalid Recurrence Rule', true));
		}
		$this->set($recurrenceRule);

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
			return $recurrenceRule;
		}
	}

/**
 * Returns the record of a Recurrence Rule.
 *
 * @param string $id, recurrence rule id.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function view($id = null) {
		$recurrenceRule = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id)));

		if (empty($recurrenceRule)) {
			throw new OutOfBoundsException(__('Invalid Recurrence Rule', true));
		}

		return $recurrenceRule;
	}

/**
 * Validates the deletion
 *
 * @param string $id, recurrence rule id 
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function validateAndDelete($id = null, $data = array()) {
		$recurrenceRule = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($recurrenceRule)) {
			throw new OutOfBoundsException(__('Invalid Recurrence Rule', true));
		}

		$this->data['recurrenceRule'] = $recurrenceRule;
		if (!empty($data)) {
			$data['RecurrenceRule']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['RecurrenceRule']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Recurrence Rule', true));
		}
	}

/**
 * Validates a recurrence rule for a particular date.
 *
 * @param array $rule An array describing a recurrence rule 
 * @param array $date A DateTime object to test the rule against.
 * @return bool true if the rule is valid for this date, false if it is not
 * @access public
 */
	public function ruleIsTrue($rule, $date) {

		extract($rule);

		/* TODO
		 * 
		 * Add support for other types of recurrence here. All recurrence
		 * modeling should be done after the iCal spec shown here:
		 * http://developer.apple.com/library/mac/documentation/AppleApplications/Reference/SyncServicesSchemaRef/Articles/Calendars.html#//apple_ref/doc/uid/TP40001540-174926
		 */
		if ($frequency == 'weekly') {
			$days = explode(',', $bydaydays);
			foreach ($days as $day) {
				if ($day == strtolower($date->format('l'))) {
					return true;
				}
			}
		}

		return false;
	}

	public function beforeSave() {
		if(!empty($this->data[$this->alias]['bydaydays']) && is_array($this->data[$this->alias]['bydaydays'])) {
			$this->data[$this->alias]['bydaydays'] = implode(',',array_values($this->data[$this->alias]['bydaydays']));	
		}
		return true;
	}

}