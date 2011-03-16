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
 *
 * @return void
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

/**
 * Test conversion of timezones
 *
 * @return void
 */
	public function testGetOffset() {
		$result = CalendarDate::getTimeZoneOffset('Europe/Berlin', '2011-02-02T15:05:46');
		$this->assertEqual($result, '+01:00');

		$result = CalendarDate::getTimeZoneOffset('Europe/Berlin', '2011-02-02 15:05:46');
		$this->assertEqual($result, '+01:00');
	}

/**
 * Test conversion of timezones
 *
 * @return void
 */
	public function testSetOffset() {
		$CalendarDate = new CalendarDate('2011-01-01 12:00:00', 'Europe/Berlin');
		$CalendarDate->setOffset(-5);
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 07:00:00');

		$CalendarDate->setOffset(+10);
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 17:00:00');

		$CalendarDate->setOffset(+05);
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 22:00:00');

		$CalendarDate->setOffset(-10);
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 12:00:00');

		$CalendarDate->setOffset('-10:00');
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 02:00:00');

		$CalendarDate->setOffset('05:00');
		$this->assertEqual($CalendarDate->format('Y-m-d H:i:s'), '2011-01-01 07:00:00');
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