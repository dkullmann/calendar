<?php
class Calendar extends CalendarAppModel {
/**
 * Name
 *
 * @var string $name
 * @access public
 */
	public $name = 'Calendar';

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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'Event' => array(
			'className' => 'Calendar.Event',
			'foreignKey' => 'calendar_id',
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
		if ($userClass = Configure::read('App.UserClass')) {
			$this->belongsTo['User']['className'] = $userClass;
		}
		parent::__construct($id, $table, $ds);
		$this->validate = array(
			'title' => array(
				'notempty' => array('rule' => array('notempty'), 'required' => true, 'allowEmpty' => false, 'message' => __('Please enter a Title', true))
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
				throw new OutOfBoundsException(__('Could not save the calendar, please check your inputs.', true));
			}
			return $return;
		}
	}

/**
 * Edits an existing Calendar.
 *
 * @param string $id, calendar id 
 * @param array $data, controller post data usually $this->data
 * @return mixed True on successfully save else post data as array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function edit($id = null, $data = null) {
		$calendar = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($calendar)) {
			throw new OutOfBoundsException(__('Invalid Calendar', true));
		}
		$this->set($calendar);

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
			return $calendar;
		}
	}

/**
 * Returns the record of a Calendar.
 *
 * @param string $id, calendar id.
 * @return array
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function view($id = null) {
		$calendar = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id)));

		if (empty($calendar)) {
			throw new OutOfBoundsException(__('Invalid Calendar', true));
		}

		return $calendar;
	}

/**
 * Validates the deletion
 *
 * @param string $id, calendar id 
 * @param array $data, controller post data usually $this->data
 * @return boolean True on success
 * @throws OutOfBoundsException If the element does not exists
 * @access public
 */
	public function validateAndDelete($id = null, $data = array()) {
		$calendar = $this->find('first', array(
			'conditions' => array(
				"{$this->alias}.{$this->primaryKey}" => $id,
				)));

		if (empty($calendar)) {
			throw new OutOfBoundsException(__('Invalid Calendar', true));
		}

		$this->data['calendar'] = $calendar;
		if (!empty($data)) {
			$data['Calendar']['id'] = $id;
			$tmp = $this->validate;
			$this->validate = array(
				'id' => array('rule' => 'notEmpty'),
				'confirm' => array('rule' => '[1]'));

			$this->set($data);
			if ($this->validates()) {
				if ($this->delete($data['Calendar']['id'])) {
					return true;
				}
			}
			$this->validate = $tmp;
			throw new Exception(__('You need to confirm to delete this Calendar', true));
		}
	}


}
?>