<div class="events form">
<?php echo $this->Form->create('Event', array('url' => array('action' => 'add', $calendarId)));?>
	<fieldset>
 		<legend><?php __('Admin Add Event');?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('recurring');
		echo $this->Form->input('time_zone');
		echo $this->Form->input('summary');
	?>
	</fieldset>
<?php echo $this->Form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('List Events', true), array('action' => 'index', $calendarId));?></li>
		<li><?php echo $this->Html->link(__('List Calendar.calendars', true), array('controller' => 'calendar.calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendar.calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar.recurrence Rules', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recurrence Rule', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>