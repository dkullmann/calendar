<?php
	$message = $this->Session->flash();
	$success = empty($this->validationMessages);
	if (!empty($event)) {
		$start = new CalendarDate($event['Event']['start_date']);
		$end   = new CalendarDate($event['Event']['end_date']);
		$event['Event']['start'] = $start->toAtom();
		$event['Event']['end'] = $end->toAtom();
		$event['Event']['url'] = $this->Html->url(array('action' => 'view', $event['Event']['id']));
		$event = $event['Event'];
	}

	echo json_encode(compact('success', 'message', 'event'));
?>