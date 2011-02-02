<?php
/* RecurrenceRule Fixture generated on: 2011-02-02 15:02:23 : 1296677603 */
class RecurrenceRuleFixture extends CakeTestFixture {
/**
 * Name
 *
 * @var string
 * @access public
 */
	public $name = 'RecurrenceRule';

/**
 * Fields
 *
 * @var array
 * @access public
 */
	public $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'event_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'by_day_days' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'frequency' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'RECURRENCE_EVENT_FK' => array('column' => 'event_id', 'unique' => 0)),
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
			'id' => '4d49bae3-5a80-44ec-a6e3-295a2944ebe5',
			'event_id' => 'Lorem ipsum dolor sit amet',
			'by_day_days' => 'Lorem ipsum dolor sit amet',
			'frequency' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-02-02 15:43:23',
			'modified' => '2011-02-02 15:43:23'
		),
	);

}
?>