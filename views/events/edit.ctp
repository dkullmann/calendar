<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php __('Edit Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('calendar_id');
		echo $this->Form->input('title');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->TimeZone->select('time_zone');
		echo $this->Form->input('summary');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Event.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Event.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Events', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recurrence Rules', true), array('controller' => 'recurrence_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recurrence Rule', true), array('controller' => 'recurrence_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>