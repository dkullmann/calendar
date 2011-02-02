<?php
/* Events Test cases generated on: 2011-02-02 14:02:15 : 1296671715*/
App::import('Controller', 'calendar.Events');

App::import('Lib', 'Templates.AppTestCase');
class EventsControllerTestCase extends AppTestCase {
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
		$this->Events = AppMock::getTestController('EventsController');
		$this->Events->constructClasses();
		$this->Events->params = array(
			'named' => array(),
			'pass' => array(),
			'url' => array());
		$fixture = new EventFixture();
		$this->record = array('Event' => $fixture->records[0]);
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
		unset($this->Events);
		ClassRegistry::flush();
	}

/**
 * Convenience method to assert Flash messages
 *
 * @return void
 * @access public
 */
	public function assertFlash($message) {
		$flash = $this->Events->Session->read('Message.flash');
		$this->assertEqual($flash['message'], $message);
		$this->Events->Session->delete('Message.flash');
	}

/**
 * Test object instances
 *
 * @return void
 * @access public
 */
	public function testInstance() {
		$this->assertIsA($this->Events, 'EventsController');
		//$this->assertIsA($this->Events->Event, 'Event');
	}



	
}
?>