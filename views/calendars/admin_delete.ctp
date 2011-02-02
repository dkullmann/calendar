<h2><?php echo sprintf(__('Delete Calendar "%s"?', true), $calendar['Calendar']['title']); ?></h2>
<p>	
	<?php __('Be aware that your Calendar and all associated data will be deleted if you confirm!'); ?>
</p>
<?php
	echo $this->Form->create('Calendar', array(
		'url' => array(
			'action' => 'delete',
			$calendar['Calendar']['id'])));
	echo $form->input('confirm', array(
		'label' => __('Confirm', true),
		'type' => 'checkbox',
		'error' => __('You have to confirm.', true)));
	echo $form->submit(__('Continue', true));
	echo $form->end();
?>