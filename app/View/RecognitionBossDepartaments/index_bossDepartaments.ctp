<div class="recognitionBossDepartaments index">
	<h2><?php echo __('Recognition Boss Departaments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('employed_id'); ?></th>
			<th><?php echo $this->Paginator->sort('points_add'); ?></th>
			<th><?php echo $this->Paginator->sort('points_delete'); ?></th>
			<th><?php echo $this->Paginator->sort('statu_id'); ?></th>
			<th><?php echo $this->Paginator->sort('descrption'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($recognitionBossDepartaments as $recognitionBossDepartament): ?>
	<tr>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($recognitionBossDepartament['Employed']['id'], array('controller' => 'trabajadores', 'action' => 'view', $recognitionBossDepartament['Employed']['id'])); ?>
		</td>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['points_add']); ?>&nbsp;</td>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['points_delete']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($recognitionBossDepartament['Statu']['name'], array('controller' => 'recognition_statuses', 'action' => 'view', $recognitionBossDepartament['Statu']['id'])); ?>
		</td>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['descrption']); ?>&nbsp;</td>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['created']); ?>&nbsp;</td>
		<td><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $recognitionBossDepartament['RecognitionBossDepartament']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $recognitionBossDepartament['RecognitionBossDepartament']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $recognitionBossDepartament['RecognitionBossDepartament']['id']), array(), __('Are you sure you want to delete # %s?', $recognitionBossDepartament['RecognitionBossDepartament']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Recognition Boss Departament'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Trabajadores'), array('controller' => 'trabajadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employed'), array('controller' => 'trabajadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Statuses'), array('controller' => 'recognition_statuses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Statu'), array('controller' => 'recognition_statuses', 'action' => 'add')); ?> </li>
	</ul>
</div>
