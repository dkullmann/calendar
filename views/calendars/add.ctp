<div class="calendars form">
<?php echo $this->Form->create('Calendar', array('url' => array('action' => 'add')));?>
	<fieldset>
 		<legend><?php __('Add Calendar');?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('title');
		echo $this->Form->input('notes');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('action' => 'index'));?></li>
	</ul>
</div>