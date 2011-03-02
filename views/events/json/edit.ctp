<?php
	$message = $this->Session->flash();
	$success = empty($this->validationMessages);
	echo json_encode(compact('success', 'message'));
?>