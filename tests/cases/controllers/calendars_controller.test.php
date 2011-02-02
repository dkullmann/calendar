<?php
/* Calendars Test cases generated on: 2011-02-02 13:02:17 : 1296669857*/
App::import('Controller', 'calendar.Calendars');

App::import('Lib', 'Templates.AppTestCase');
class CalendarsControllerTestCase extends AppTestCase {
/**
 * Autoload entrypoint for fixtures dependecy solver
 *
 * @var string
 * @access public
 */
	public $plugin = 'app';

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 * @access protected
 */
	protected $_testsToRun = array();

/**
 * Start Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function startTest($method) {
		parent::startTest($method);
		$this->Calendars = AppMock::getTestController('CalendarsController');
		$this->Calendars->constructClasses();
		$this->Calendars->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
		$fixture = new CalendarFixture();
		$this->record = array('Calendar' => $fixture->records[0]);
	}

/**
 * End Test callback
 *
 * @param string $method
 * @return void
 * @access public
 */
	public function endTest($method) {
		parent::endTest($method);
		unset($this->Calendars);
		ClassRegistry::flush();
	}

/**
 * Convenience method to assert Flash messages
 *
 * @return void
 * @access public
 */
	public function assertFlash($message) {
		$flash = $this->Calendars->Session->read('Message.flash');
		$this->assertEqual($flash['message'], $message);
		$this->Calendars->Session->delete('Message.flash');
	}

/**
 * Test object instances
 *
 * @return void
 * @access public
 */
	public function testInstance() {
		$this->assertIsA($this->Calendars, 'CalendarsController');
		//$this->assertIsA($this->Calendars->Calendar, 'Calendar');
	}



	
}
?>