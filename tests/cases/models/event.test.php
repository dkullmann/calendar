<?php
/* Event Test cases generated on: 2011-02-02 14:02:38 : 1296671498*/
App::import('Model', 'calendar.Event');

App::import('Lib', 'Templates.AppTestCase');
class EventTestCase extends AppTestCase {
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
		$this->Event = AppMock::getTestModel('Event');
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
		unset($this->Event);
		ClassRegistry::flush();
	}

/**
 * Test adding a Event 
 *
 * @return void
 * @access public
 */
	public function testAdd() {
		$data = $this->record;
		unset($data['Event']['id']);
		$result = $this->Event->add(99, $data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['Event']['id']);
			//unset($data['Event']['title']);
			$result = $this->Event->add(99, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a Event 
 *
 * @return void
 * @access public
 */
	public function testEdit() {
		$result = $this->Event->edit('event-1', null);

		$expected = $this->Event->read(null, 'event-1');
		$this->assertEqual($result['Event'], $expected['Event']);

		// put invalidated data here
		$data = $this->record;
		//$data['Event']['title'] = null;

		$result = $this->Event->edit('event-1', $data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this->Event->edit('event-1', $data);
		$this->assertTrue($result);

		$result = $this->Event->read(null, 'event-1');

		// put record specific asserts here for example
		// $this->assertEqual($result['Event']['title'], $data['Event']['title']);

		try {
			$this->Event->edit('wrong_id', $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test viewing a single Event 
 *
 * @return void
 * @access public
 */
	public function testView() {
		$result = $this->Event->view('event-1');
		$this->assertTrue(isset($result['Event']));
		$this->assertEqual($result['Event']['id'], 'event-1');

		try {
			$result = $this->Event->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a Event 
 *
 * @return void
 * @access public
 */
	public function testValidateAndDelete() {
		try {
			$postData = array();
			$this->Event->validateAndDelete('invalidEventId', $postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid Event');
		}
		try {
			$postData = array(
				'Event' => array(
					'confirm' => 0));
			$result = $this->Event->validateAndDelete('event-1', $postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Event');
		}

		$postData = array(
			'Event' => array(
				'confirm' => 1));
		$result = $this->Event->validateAndDelete('event-1', $postData);
		$this->assertTrue($result);
	}
	
}
?>