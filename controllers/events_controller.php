<?php
App::import('Lib', 'Calendar.CalendarDate');

class EventsController extends CalendarAppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Events';

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Time', 'Calendar.TimeZone', 'Calendar.DatePicker', 'Calendar.Calendar');

/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler');


	function beforeFilter() {
		if (isset($this->Auth)) {
			$this->Auth->allow('index');
		}
	}

/**
 * Index for event.
 *
 * @param string $calendarId, Calendar id 
 * @access public
 */
	public function index($calendarId = null, $viewType = null) {
		if ($calendarId) {
			$this->paginate['conditions']['calendar_id'] = $calendarId;
		}
		$offset = 0;
		if (!empty($this->params['url']['browserOffset'])) {
			$this->set('browserOffset', $this->params['url']['browserOffset']);
			$offset = $this->params['url']['browserOffset']; 
		}

		if (!empty($this->params['url']['start'])) {
			$this->paginate['conditions']['start_date'] = CalendarDate::unixToDate($this->params['url']['start'], $offset);
		}

		if (!empty($this->params['url']['end'])) {
			$this->paginate['conditions']['end_date'] = CalendarDate::unixToDate($this->params['url']['end'], $offset);
		}

		$this->paginate['contain'][] = 'RecurrenceRule';
		$this->paginate['viewType'] = $viewType;
		$this->set('events', $this->paginate());
		$this->set(compact('calendarId')); 
	}

/**
 * View for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function view($id = null) {
		try {
			$event = $this->Event->view($id);
			$calendarId = $event['Event']['calendar_id'];
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		
			$this->redirect('/');
		}
		$this->set(compact('event'));
		$this->set(compact('calendarId')); 
	}

/**
 * Add for event.
 *
 * @param string $calendarId, Calendar id 
 * @access public
 */
	public function add($calendarId) {
		try {
			$result = $this->Event->add($calendarId, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('controller' => 'calendars', 'action' => 'view', $calendarId));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index', $calendarId));
		}
		$this->set(compact('calendarId')); 
	}

/**
 * Edit for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function edit($id = null) {
		try {
			$result = $this->Event->edit($id, $this->data);
			if ($result === true) {
				$calendarId = $this->Event->data['Event']['calendar_id'];
				$this->Session->setFlash(__('Event saved', true));
				$this->redirect(array('action' => 'view', $this->Event->data['Event']['id']));
			} else {
				$this->data = $result;
				$calendarId = $this->data['Event']['calendar_id'];
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$calendars = $this->Event->Calendar->find('list');
		$this->set(compact('calendars'));
		$this->set(compact('calendarId')); 
	}

/**
 * Delete for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function delete($id = null) {
		try {
			$event = $this->Event->view($id);
			$calendarId = $event['Event']['calendar_id'];			
			$this->set(compact('calendarId'));
			if ($this->RequestHandler->isDelete()) {
				$this->data[$this->Event->alias]['confirm'] = '1';
			}
			$result = $this->Event->validateAndDelete($id, $this->Auth->user('id'), $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Event deleted', true));
				$this->redirect(array('action' => 'index', $calendarId));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		if (!empty($this->Event->data['event'])) {
			$this->set('event', $this->Event->data['event']);
		}
	}

/**
 * Admin index for event.
 *
 * @param string $calendarId, Calendar id 
 * @access public
 */
	public function admin_index($calendarId) {
		$this->Event->recursive = 0;
		if ($calendarId) {
			$this->paginate['conditions']['calendar_id'] = $calendarId;
		}
		$this->set('events', $this->paginate());
		$this->set(compact('calendarId'));
	}

/**
 * Admin view for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function admin_view($id = null) {
		try {
			$event = $this->Event->view($id);
			$calendarId = $event['Event']['calendar_id'];
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$this->set(compact('event'));
		$this->set(compact('calendarId')); 
	}

/**
 * Admin add for event.
 *
 * @param string $calendarId, Calendar id 
 * @access public
 */
	public function admin_add($calendarId) {
		try {
			$result = $this->Event->add($calendarId, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index', $calendarId));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index', $calendarId));
		}
		$calendars = $this->Event->Calendar->find('list');
		$this->set(compact('calendars'));
		$this->set(compact('calendarId')); 
	}

/**
 * Admin edit for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function admin_edit($id = null) {
		try {
			$result = $this->Event->edit($id, $this->data);
			if ($result === true) {
				$calendarId = $this->Event->data['Event']['calendar_id'];
				$this->Session->setFlash(__('Event saved', true));
				$this->redirect(array('action' => 'view', $this->Event->data['Event']['id']));
			} else {
				$this->data = $result;
				$calendarId = $this->data['Event']['calendar_id'];
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$calendars = $this->Event->Calendar->find('list');
		$this->set(compact('calendars'));
		$this->set(compact('calendarId')); 
	}

/**
 * Admin delete for event.
 *
 * @param string $id, event id 
 * @access public
 */
	public function admin_delete($id = null) {
		try {
			$event = $this->Event->view($id);
			$calendarId = $event['Event']['calendar_id'];			
			$this->set(compact('calendarId')); 
			$result = $this->Event->validateAndDelete($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Event deleted', true));
				$this->redirect(array('action' => 'index', $calendarId));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		if (!empty($this->Event->data['event'])) {
			$this->set('event', $this->Event->data['event']);
		}
	}

}