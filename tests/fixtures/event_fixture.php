<?php
/* Event Fixture generated on: 2011-02-02 14:02:38 : 1296671498 */
class EventFixture extends CakeTestFixture {
/**
 * Name
 *
 * @var string
 * @access public
 */
	public $name = 'Event';

/**
 * Fields
 *
 * @var array
 * @access public
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'calendar_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'start_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'recurring' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'time_zone' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'summary' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'EVENTS_CALENDAR_FK' => array('column' => 'calendar_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 * @access public
 */
	public $records = array(
		array(
			'id' => '4d49a30a-3200-441d-b8a1-28502944ebe5',
			'calendar_id' => 'Lorem ipsum dolor sit amet',
			'title' => 'Lorem ipsum dolor sit amet',
			'start_date' => '2011-02-02 14:01:38',
			'end_date' => '2011-02-02 14:01:38',
			'recurring' => 1,
			'time_zone' => 'Lorem ipsum dolor sit amet',
			'summary' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-02 14:01:38',
			'modified' => '2011-02-02 14:01:38'
		),
	);

}
?>