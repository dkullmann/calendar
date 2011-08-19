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
		$this->recurringRecord = array('Event' => $fixture->records[2]);
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
		
		// $event = $this->Event->read();

		$result = $this->Event->add(100, $data, 'weekly');
		$this->assertTrue($result);

		$id = $this->Event->id;
		$events = $this->Event->find('all', array(
			'conditions' => array($this->Event->alias.'.id' => $this->Event->id),
			'recurs' => array(
				'from' => date('Y-m-d', strtotime('+10 weeks')),
				'to' => date('Y-m-d', strtotime('+11 weeks'))
			)
		));

		$records = Set::extract(sprintf('/Event[id=/%s/]', $id), $events);
		$this->assertEqual(count($records), 1);

		try {
			$data = $this->record;
			unset($data['Event']['id']);
			unset($data['Event']['title']);
			$result = $this->Event->add(99, $data);
			$this->fail('No exception');
		} catch (OutOfBoundsException $e) {
			$this->pass('Correct exception thrown');
		}
		
	}
	
/**
 * Test localization behavior integration
 *
 * @return void
 * @author David Kullmann
 */
	public function testLocalization() {
		$data = $this->record;
		$local_time_zone = $data['Event']['time_zone'];
		unset($data['Event']['id']);
		
		LocalizeTime::setUserTimeZone($local_time_zone);

		$result = $this->Event->add(99, $data);
		$this->assertTrue($result);
		
		$this->Event->Behaviors->detach('LocalizeTime');		
		$event = $this->Event->read();
		$LclDateTimeZone  = new DateTimeZone($local_time_zone);
		$UtcDateTimeZone  = new DateTimeZone('UTC');
		$DateTimeStart = new DateTime($data['Event']['start_date'], $LclDateTimeZone);
		$DateTimeEnd   = new DateTime($data['Event']['end_date'], $LclDateTimeZone);
		
		$DateTimeStart->setTimezone($UtcDateTimeZone);;
		$DateTimeEnd->setTimezone($UtcDateTimeZone);;
		
		$this->assertEqual(
			$DateTimeStart->format('Y-m-d H:i:s'),
			$event[$this->Event->alias]['start_date']
		);

		$this->assertEqual(
			$DateTimeEnd->format('Y-m-d H:i:s'),
			$event[$this->Event->alias]['end_date']
		);
	}
/**
 * Test integration with recurrence behavior
 *
 * @return void
 * @author David Kullmann
 */
	public function testRecurrence() {
		$data = $this->recurringRecord;
		$results = $this->Event->find('all', array(
			'recurs' => array(
				'from' => date('Y-m-d'),
				'to' => date('Y-m-d', strtotime('+1 weeks')),
			)
		));
		
		$records = Set::extract(sprintf('/Event[id=/%s/]', $data['Event']['id']), $results);
		$this->assertEqual(count($records), 1);
		
		$results = $this->Event->find('all', array(
			'recurs' => array(
				'from' => date('Y-m-d'),
				'to' => date('Y-m-d', strtotime('+4 weeks')),
			)
		));
		
		$records = Set::extract(sprintf('/Event[id=/%s/]', $data['Event']['id']), $results);
		$this->assertEqual(count($records), 4);
	}

/**
 * Test editing a Event 
 *
 * @return void
 * @access public
 */
	public function testEdit() {
		$data = $this->record;
		$id = $data[$this->Event->alias]['id'];
		$user_id = $this->Event->Calendar->field('user_id',
			array($this->Event->Calendar->alias.'.id' => $data[$this->Event->alias]['calendar_id'])
		);
		$result = $this->Event->edit($id, $user_id, null);
		
		$expected = $this->Event->read(null, $id);
		$this->assertEqual($result['Event'], $expected['Event']);
		
		// put invalidated data here
		$data['Event']['title'] = null;
		
		$result = $this->Event->edit($id, $user_id, $data);
		$this->assertEqual($result, $data);
		
		$data = $this->record;
		
		$result = $this->Event->edit($id, $user_id, $data);
		$this->assertTrue($result);
		
		$result = $this->Event->read(null, $id);
		
		// put record specific asserts here for example
		// $this->assertEqual($result['Event']['title'], $data['Event']['title']);

		$result = $this->Event->edit($id, $user_id, $data, 'weekly');
		$this->assertTrue($result);

		$events = $this->Event->find('all', array(
			'conditions' => array($this->Event->alias.'.id' => $this->Event->id),
			'recurs' => array(
				'from' => date('Y-m-d', strtotime('+10 weeks')),
				'to' => date('Y-m-d', strtotime('+11 weeks'))
			)
		));

		$records = Set::extract(sprintf('/Event[id=/%s/]', $id), $events);
		$this->assertEqual(count($records), 1);
	
		try {
			$this->Event->edit('wrong_id', $user_id, $data);
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
		$data = $this->record;
		$id = $data[$this->Event->alias]['id'];
		$result = $this->Event->view($id);
		$this->assertTrue(isset($result['Event']));
		$this->assertEqual($result['Event']['id'], $id);

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
		$data = $this->record;
		$id = $data[$this->Event->alias]['id'];
		$user_id = $this->Event->Calendar->field('user_id',
			array($this->Event->Calendar->alias.'.id' => $data[$this->Event->alias]['calendar_id'])
		);
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
				$result = $this->Event->validateAndDelete($id, $user_id, $postData);
			} catch (Exception $e) {
				$this->assertEqual($e->getMessage(), 'You need to confirm to delete this Event');
			}
	
		$postData = array(
			'Event' => array(
				'confirm' => 1));
		$result = $this->Event->validateAndDelete($id, $user_id, $postData);
		$this->assertTrue($result);
	}
	
}
?>