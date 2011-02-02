<?php
/* Calendar Test cases generated on: 2011-02-02 13:02:14 : 1296669614*/
App::import('Model', 'calendar.Calendar');

App::import('Lib', 'Templates.AppTestCase');
class CalendarTestCase extends AppTestCase {
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
		$this->Calendar = AppMock::getTestModel('Calendar');
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
		unset($this->Calendar);
		ClassRegistry::flush();
	}

/**
 * Test adding a Calendar 
 *
 * @return void
 * @access public
 */
	public function testAdd() {
		$data = $this->record;
		unset($data['Calendar']['id']);
		$result = $this->Calendar->add($data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['Calendar']['id']);
			//unset($data['Calendar']['title']);
			$result = $this->Calendar->add($data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a Calendar 
 *
 * @return void
 * @access public
 */
	public function testEdit() {
		$result = $this->Calendar->edit('calendar-1', null);

		$expected = $this->Calendar->read(null, 'calendar-1');
		$this->assertEqual($result['Calendar'], $expected['Calendar']);

		// put invalidated data here
		$data = $this->record;
		//$data['Calendar']['title'] = null;

		$result = $this->Calendar->edit('calendar-1', $data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this->Calendar->edit('calendar-1', $data);
		$this->assertTrue($result);

		$result = $this->Calendar->read(null, 'calendar-1');

		// put record specific asserts here for example
		// $this->assertEqual($result['Calendar']['title'], $data['Calendar']['title']);

		try {
			$this->Calendar->edit('wrong_id', $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test viewing a single Calendar 
 *
 * @return void
 * @access public
 */
	public function testView() {
		$result = $this->Calendar->view('calendar-1');
		$this->assertTrue(isset($result['Calendar']));
		$this->assertEqual($result['Calendar']['id'], 'calendar-1');

		try {
			$result = $this->Calendar->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a Calendar 
 *
 * @return void
 * @access public
 */
	public function testValidateAndDelete() {
		try {
			$postData = array();
			$this->Calendar->validateAndDelete('invalidCalendarId', $postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid Calendar');
		}
		try {
			$postData = array(
				'Calendar' => array(
					'confirm' => 0));
			$result = $this->Calendar->validateAndDelete('calendar-1', $postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Calendar');
		}

		$postData = array(
			'Calendar' => array(
				'confirm' => 1));
		$result = $this->Calendar->validateAndDelete('calendar-1', $postData);
		$this->assertTrue($result);
	}
	
}
?>