<?php
class AttendeeFixture extends CakeTestFixture {
/**
 * Name
 *
 * @var string
 * @access public
 */
	public $name = 'Attendee';

/**
 * Fields
 *
 * @var array
 * @access public
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'user_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'event_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36),
		'role' => array('type' => 'string', 'null' => false, 'default' => 'requiredparticipant', 'length' => 20),
		'rsvp' => array('type' => 'boolean', 'null' => false, 'default' => false),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		)
	);

/**
 * Records
 *
 * @var array
 * @access public
 */
	public $records = array(
		array(
			'id' => '4d499bae-edc4-4a21-9596-27b22944ebe5',
			'user_id' => 'Lorem ipsum dolor sit amet',
			'event_id' => 'Lorem ipsum dolor sit amet',
			'role' => 'Lorem ipsum dolor sit amet',
			'rsvp' => '',
			'created' => '2011-02-02 13:30:14',
			'modified' => '2011-02-02 13:30:14'
		),
	);

}