<?php
	$message = $this->Session->flash();
	$success = empty($event) && !empty($calendarId);
	echo json_encode(compact('success', 'message'));
?>