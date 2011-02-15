<?php

class Attendee extends CalendarAppModel {

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
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
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
		if ($userClass = Configure::read('App.UserClass')) {
			$this->belongsTo['User']['className'] = $userClass;
		}
		parent::__construct($id, $table, $ds);
	}
}