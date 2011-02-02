<div class="calendars view">
<h2><?php  __('Calendar');?></h2>
	<?php echo $this->element('calendar/calendar'); ?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendar', true), array('action' => 'edit', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Calendar', true), array('action' => 'delete', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('New Event', true), array('controller' => 'events', 'action' => 'add', $calendar['Calendar']['id'])); ?> </li>
	</ul>
</div>