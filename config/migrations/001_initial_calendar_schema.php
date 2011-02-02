<?php
class M4d49956028644ae7816327252944ebe5 extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 * @access public
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 * @access public
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'calendars' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'user_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'key' => 'index'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
					'notes' => array('type' => 'string', 'null' => false, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'CALENDAR_USER_FK' => array('column' => 'user_id', 'unique' => 0),
					)
				),
				'events' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'calendar_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index'),
					'title' => array('type' => 'string', 'null' => false, 'default' => NULL),
					'start_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'end_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'recurring' => array('type' => 'boolean', 'null' => false, 'default' => false),
					'time_zone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
					'summary' => array('type' => 'string', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'EVENTS_CALENDAR_FK' => array('column' => 'calendar_id', 'unique' => 0),
					)
				),
				'recurrence_rules' => array(
					'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
					'event_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index'),
					'by_day_days' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
					'frequency' => array('type' => 'string', 'null' => true, 'default' => NULL),
					'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
					'indexes' => array(
						'PRIMARY' => array('column' => 'id', 'unique' => 1),
						'RECURRENCE_EVENT_FK' => array('column' => 'event_id', 'unique' => 0),
					)
				),
			),
		),
		'down' => array(
			'drop_table' => array(
				'calendars', 'events', 'recurrence_rules'
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 * @access public
 */
	public function after($direction) {
		return true;
	}
}
?>