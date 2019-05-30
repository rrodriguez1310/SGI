<div class="estadios index">
	<h2><?php echo __('Estadios'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('ciudad'); ?></th>
			<th><?php echo $this->Paginator->sort('localia'); ?></th>
			<th><?php echo $this->Paginator->sort('divisione_id'); ?></th>
			<th><?php echo $this->Paginator->sort('localia_equipo_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($estadios as $estadio): ?>
	<tr>
		<td><?php echo h($estadio['Estadio']['id']); ?>&nbsp;</td>
		<td><?php echo h($estadio['Estadio']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($estadio['Estadio']['ciudad']); ?>&nbsp;</td>
		<td><?php echo h($estadio['Estadio']['localia']); ?>&nbsp;</td>
		<td><?php echo h($estadio['Estadio']['divisione_id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($estadio['LocaliaEquipo']['id'], array('controller' => 'equipos', 'action' => 'view', $estadio['LocaliaEquipo']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $estadio['Estadio']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $estadio['Estadio']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $estadio['Estadio']['id']), array(), __('Are you sure you want to delete # %s?', $estadio['Estadio']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Estadio'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Localia Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
