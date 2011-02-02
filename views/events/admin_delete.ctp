<h2><?php echo sprintf(__('Delete Event "%s"?', true), $event['Event']['title']); ?></h2>
<p>	
	<?php __('Be aware that your Event and all associated data will be deleted if you confirm!'); ?>
</p>
<?php
	echo $this->Form->create('Event', array(
		'url' => array(
			'action' => 'delete',
			$event['Event']['id'])));
	echo $form->input('confirm', array(
		'label' => __('Confirm', true),
		'type' => 'checkbox',
		'error' => __('You have to confirm.', true)));
	echo $form->submit(__('Continue', true));
	echo $form->end();
?>