<div class="programaciones index">
	<h2><?php echo __('Programaciones'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('log_programa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('hora'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('channel_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($programaciones as $programacione): ?>
	<tr>
		<td><?php echo h($programacione['Programacione']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($programacione['LogPrograma']['id'], array('controller' => 'log_programas', 'action' => 'view', $programacione['LogPrograma']['id'])); ?>
		</td>
		<td><?php echo h($programacione['Programacione']['hora']); ?>&nbsp;</td>
		<td><?php echo h($programacione['Programacione']['fecha']); ?>&nbsp;</td>
		<td><?php echo h($programacione['Programacione']['nombre']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($programacione['Channel']['id'], array('controller' => 'channels', 'action' => 'view', $programacione['Channel']['id'])); ?>
		</td>
		<td><?php echo h($programacione['Programacione']['created']); ?>&nbsp;</td>
		<td><?php echo h($programacione['Programacione']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $programacione['Programacione']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $programacione['Programacione']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $programacione['Programacione']['id']), array(), __('Are you sure you want to delete # %s?', $programacione['Programacione']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Programacione'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Log Programas'), array('controller' => 'log_programas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Log Programa'), array('controller' => 'log_programas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Channels'), array('controller' => 'channels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Channel'), array('controller' => 'channels', 'action' => 'add')); ?> </li>
	</ul>
</div>
