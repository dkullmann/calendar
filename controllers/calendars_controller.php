<?php
class CalendarsController extends CalendarAppController {
/**
 * Controller name
 *
 * @var string
 * @access public
 */
	public $name = 'Calendars';

/**
 * Helpers
 *
 * @var array
 * @access public
 */
	public $helpers = array('Html', 'Form');

/**
 * Index for calendar.
 * 
 * @access public
 */
	public function index() {
		$this->Calendar->recursive = 0;
		$this->set('calendars', $this->paginate()); 
	}

/**
 * View for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function view($id = null) {
		try {
			$calendar = $this->Calendar->view($id);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('calendar')); 
	}

/**
 * Add for calendar.
 * 
 * @access public
 */
	public function add() {
		try {
			$result = $this->Calendar->add($this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The calendar has been saved', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$users = $this->Calendar->User->find('list');
		$this->set(compact('users'));
 
	}

/**
 * Edit for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function edit($id = null) {
		try {
			$result = $this->Calendar->edit($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Calendar saved', true));
				$this->redirect(array('action' => 'view', $this->Calendar->data['Calendar']['id']));
				
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$users = $this->Calendar->User->find('list');
		$this->set(compact('users'));
 
	}

/**
 * Delete for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function delete($id = null) {
		try {
			$result = $this->Calendar->validateAndDelete($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Calendar deleted', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->Calendar->data['calendar'])) {
			$this->set('calendar', $this->Calendar->data['calendar']);
		}
	}

/**
 * Admin index for calendar.
 * 
 * @access public
 */
	public function admin_index() {
		$this->Calendar->recursive = 0;
		$this->set('calendars', $this->paginate()); 
	}

/**
 * Admin view for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function admin_view($id = null) {
		try {
			$calendar = $this->Calendar->view($id);
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->set(compact('calendar')); 
	}

/**
 * Admin add for calendar.
 * 
 * @access public
 */
	public function admin_add() {
		try {
			$result = $this->Calendar->add($this->data);
			if ($result === true) {
				$this->Session->setFlash(__('The calendar has been saved', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$users = $this->Calendar->User->find('list');
		$this->set(compact('users'));
 
	}

/**
 * Admin edit for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function admin_edit($id = null) {
		try {
			$result = $this->Calendar->edit($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Calendar saved', true));
				$this->redirect(array('action' => 'view', $this->Calendar->data['Calendar']['id']));
				
			} else {
				$this->data = $result;
			}
		} catch (OutOfBoundsException $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect('/');
		}
		$users = $this->Calendar->User->find('list');
		$this->set(compact('users'));
 
	}

/**
 * Admin delete for calendar.
 *
 * @param string $id, calendar id 
 * @access public
 */
	public function admin_delete($id = null) {
		try {
			$result = $this->Calendar->validateAndDelete($id, $this->data);
			if ($result === true) {
				$this->Session->setFlash(__('Calendar deleted', true));
				$this->redirect(array('action' => 'index'));
			}
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->Calendar->data['calendar'])) {
			$this->set('calendar', $this->Calendar->data['calendar']);
		}
	}

}
?>