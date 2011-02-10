<?php
App::import('Lib', array('Calendar.CalendarDate'));

/**
 * Comment Widget Helper Test
 *
 * @package comments
 * @subpackage comment.tests.cases.helpers
 */
class CalendarDateTest extends CakeTestCase {

/**
 * Fixtures property
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Start test method
 *
 * @return void
 */
	public function startTest($method) {
		parent::startTest($method);
	}

/**
 * Test conversion of timezones
 */
	public function testConvert() {
		$result = CalendarDate::convertTimeZone('1985-04-12 20:00:00', 'Europe/Berlin', 'America/New_York');
		$this->assertEqual($result, '1985-04-12 13:00:00');

		$result = CalendarDate::convertTimeZone('1985-04-12 20:00:00', 'Europe/Berlin', 'America/New_York');
		$this->assertEqual($result, '1985-04-12 13:00:00');

		// Yes +4 is right, summertime!
		$result = CalendarDate::convertTimeZone('1985-04-12 20:00:00', 'Europe/Berlin', 'Europe/Moscow');
		$this->assertEqual($result, '1985-04-12 22:00:00');
	}

	public function testGetOffset() {
		$result = CalendarDate::getTimeZoneOffset('Europe/Berlin', '2011-02-02T15:05:46');
		$this->assertEqual($result, '+01:00');

		$result = CalendarDate::getTimeZoneOffset('Europe/Berlin', '2011-02-02 15:05:46');
		$this->assertEqual($result, '+01:00');
	}

/**
 * End test method
 *
 * @return void
 */
	public function endTest($method) {
		ClassRegistry::flush();
	}

}