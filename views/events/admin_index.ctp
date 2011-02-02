<div class="events index">
<h2><?php __('Events');?></h2>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('calendar_id');?></th>
	<th><?php echo $this->Paginator->sort('title');?></th>
	<th><?php echo $this->Paginator->sort('start_date');?></th>
	<th><?php echo $this->Paginator->sort('end_date');?></th>
	<th><?php echo $this->Paginator->sort('recurring');?></th>
	<th><?php echo $this->Paginator->sort('time_zone');?></th>
	<th><?php echo $this->Paginator->sort('summary');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($events as $event):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $event['Event']['id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($event['Calendar']['title'], array('controller' => 'calendar.calendars', 'action' => 'view', $event['Calendar']['id'])); ?>
		</td>
		<td>
			<?php echo $event['Event']['title']; ?>
		</td>
		<td>
			<?php echo $event['Event']['start_date']; ?>
		</td>
		<td>
			<?php echo $event['Event']['end_date']; ?>
		</td>
		<td>
			<?php echo $event['Event']['recurring']; ?>
		</td>
		<td>
			<?php echo $event['Event']['time_zone']; ?>
		</td>
		<td>
			<?php echo $event['Event']['summary']; ?>
		</td>
		<td>
			<?php echo $event['Event']['created']; ?>
		</td>
		<td>
			<?php echo $event['Event']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $event['Event']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $event['Event']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
<?php echo $this->element('paging',array('plugin'=>'templates')); ?>
</div>

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('New Event', true), array('action' => 'add', $calendarId)); ?></li>
		<li><?php echo $this->Html->link(__('List Calendar.calendars', true), array('controller' => 'calendar.calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendar.calendars', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar.recurrence Rules', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recurrence Rule', true), array('controller' => 'calendar.recurrence_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>
