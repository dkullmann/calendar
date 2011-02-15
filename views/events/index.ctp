<?php

	$this->Html->script(array(
			'/calendar/js/datepicker/date.js',
			'/calendar/js/datepicker/jquery.datePicker.js',
			'/calendar/js/datepicker/cake.datePicker.js',
		),
		array('inline' => false)
	);
	
	$this->Html->css('/calendar/css/datepicker/datePicker.css', 'stylesheet', array('inline' => false));
?>
<div class="events form">
<?php echo $this->Form->create('Event');?>
	<fieldset>
 		<legend><?php __('Find Events'); ?></legend>
	<?php

		echo $this->DatePicker->picker('start_date');
		echo $this->DatePicker->picker('end_date');
		echo $this->TimeZone->select('time_zone');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

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
			<?php echo $this->Html->link($event['Calendar']['title'], array('controller' => 'calendars', 'action' => 'view', $event['Calendar']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('List Calendars', true), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar', true), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
	</ul>
</div>
