<?php

$json_events = array();

foreach($events as $event) {

	/* Could set defaults here */
	$json_event = array();
	
	$start = new CalendarDate($event['Event']['start_date']);
	$end   = new CalendarDate($event['Event']['end_date']);

	$start->setOffset($browserOffset);
	$end->setOffset($browserOffset);
	
	/* Event properties from http://arshaw.com/fullcalendar/docs/event_data/Event_Object/ */
	$json_event['id']		= $event['Event']['id'];
	$json_event['title']	= $event['Event']['title'];
	$json_event['start']	= $start->toAtom();
	$json_event['end']		= $end->toAtom();
	$json_event['url']      = $this->Html->url(array('action' => 'view', $event['Event']['id']));
	$json_event['type']     = $event['Event']['type'];

	/* Other available attributes for fullCalendar.js */
	#$event['allDay']	= false;
	#$json_event['url']
	#$json_event['className']
	#$json_event['editable']

	$json_events[] = $json_event;
}

echo $this->Js->object($json_events); ?>