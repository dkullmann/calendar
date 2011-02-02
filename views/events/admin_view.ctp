<div class="events view">
<h2><?php  __('Event');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Calendar'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($event['Calendar']['title'], array('controller' => 'calendar.calendars', 'action' => 'view', $event['Calendar']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Title'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['start_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('End Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['end_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Recurring'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['recurring']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Time Zone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['time_zone']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Summary'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['summary']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $event['Event']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Edit Event', true), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Event', true), array('action' => 'delete', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Events', true), array('action' => 'index', $calendarId)); ?> </li>
		<li><?php echo $this->Html->link(__('New Event', true), array('action' => 'add', $calendarId)); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar.calendars', true), array('controller' => 'calendar.calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendar.calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar.recurrence Rules', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recurrence Rule', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Calendar.recurrence Rules');?></h3>
	<?php if (!empty($event['RecurrenceRule'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Event Id'); ?></th>
		<th><?php __('By Day Days'); ?></th>
		<th><?php __('Frequency'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($event['RecurrenceRule'] as $recurrenceRule):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $recurrenceRule['id'];?></td>
			<td><?php echo $recurrenceRule['event_id'];?></td>
			<td><?php echo $recurrenceRule['by_day_days'];?></td>
			<td><?php echo $recurrenceRule['frequency'];?></td>
			<td><?php echo $recurrenceRule['created'];?></td>
			<td><?php echo $recurrenceRule['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'view', $recurrenceRule['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'edit', $recurrenceRule['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'delete', $recurrenceRule['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $recurrenceRule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Recurrence Rule', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
