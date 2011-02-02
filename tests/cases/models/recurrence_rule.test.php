<?php
/* RecurrenceRule Test cases generated on: 2011-02-02 15:02:23 : 1296677603*/
App::import('Model', 'calendar.RecurrenceRule');

App::import('Lib', 'Templates.AppTestCase');
class RecurrenceRuleTestCase extends AppTestCase {
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
		$this->RecurrenceRule = AppMock::getTestModel('RecurrenceRule');
		$fixture = new RecurrenceRuleFixture();
		$this->record = array('RecurrenceRule' => $fixture->records[0]);
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
		unset($this->RecurrenceRule);
		ClassRegistry::flush();
	}

/**
 * Test adding a Recurrence Rule 
 *
 * @return void
 * @access public
 */
	public function testAdd() {
		$data = $this->record;
		unset($data['RecurrenceRule']['id']);
		$result = $this->RecurrenceRule->add($data);
		$this->assertTrue($result);
		
		try {
			$data = $this->record;
			unset($data['RecurrenceRule']['id']);
			//unset($data['RecurrenceRule']['title']);
			$result = $this->RecurrenceRule->add($data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
		
	}

/**
 * Test editing a Recurrence Rule 
 *
 * @return void
 * @access public
 */
	public function testEdit() {
		$result = $this->RecurrenceRule->edit('recurrencerule-1', null);

		$expected = $this->RecurrenceRule->read(null, 'recurrencerule-1');
		$this->assertEqual($result['RecurrenceRule'], $expected['RecurrenceRule']);

		// put invalidated data here
		$data = $this->record;
		//$data['RecurrenceRule']['title'] = null;

		$result = $this->RecurrenceRule->edit('recurrencerule-1', $data);
		$this->assertEqual($result, $data);

		$data = $this->record;

		$result = $this->RecurrenceRule->edit('recurrencerule-1', $data);
		$this->assertTrue($result);

		$result = $this->RecurrenceRule->read(null, 'recurrencerule-1');

		// put record specific asserts here for example
		// $this->assertEqual($result['RecurrenceRule']['title'], $data['RecurrenceRule']['title']);

		try {
			$this->RecurrenceRule->edit('wrong_id', $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test viewing a single Recurrence Rule 
 *
 * @return void
 * @access public
 */
	public function testView() {
		$result = $this->RecurrenceRule->view('recurrencerule-1');
		$this->assertTrue(isset($result['RecurrenceRule']));
		$this->assertEqual($result['RecurrenceRule']['id'], 'recurrencerule-1');

		try {
			$result = $this->RecurrenceRule->view('wrong_id');
			$this->fail('No exception on wrong id');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
	}

/**
 * Test ValidateAndDelete method for a Recurrence Rule 
 *
 * @return void
 * @access public
 */
	public function testValidateAndDelete() {
		try {
			$postData = array();
			$this->RecurrenceRule->validateAndDelete('invalidRecurrenceRuleId', $postData);
		} catch (OutOfBoundsException $e) {
			$this->assertEqual($e->getMessage(), 'Invalid Recurrence Rule');
		}
		try {
			$postData = array(
				'RecurrenceRule' => array(
					'confirm' => 0));
			$result = $this->RecurrenceRule->validateAndDelete('recurrencerule-1', $postData);
		} catch (Exception $e) {
			$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Recurrence Rule');
		}

		$postData = array(
			'RecurrenceRule' => array(
				'confirm' => 1));
		$result = $this->RecurrenceRule->validateAndDelete('recurrencerule-1', $postData);
		$this->assertTrue($result);
	}
	
}
?>