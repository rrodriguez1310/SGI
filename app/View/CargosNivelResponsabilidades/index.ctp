<div class="cargosNivelResponsabilidades index">
	<h2><?php echo __('Cargos Nivel Responsabilidades'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nivel'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($cargosNivelResponsabilidades as $cargosNivelResponsabilidade): ?>
	<tr>
		<td><?php echo h($cargosNivelResponsabilidade['CargosNivelResponsabilidade']['id']); ?>&nbsp;</td>
		<td><?php echo h($cargosNivelResponsabilidade['CargosNivelResponsabilidade']['nivel']); ?>&nbsp;</td>
		<td><?php echo h($cargosNivelResponsabilidade['CargosNivelResponsabilidade']['estado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $cargosNivelResponsabilidade['CargosNivelResponsabilidade']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $cargosNivelResponsabilidade['CargosNivelResponsabilidade']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $cargosNivelResponsabilidade['CargosNivelResponsabilidade']['id']), array(), __('Are you sure you want to delete # %s?', $cargosNivelResponsabilidade['CargosNivelResponsabilidade']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Cargos Nivel Responsabilidade'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Cargos'), array('controller' => 'cargos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cargo'), array('controller' => 'cargos', 'action' => 'add')); ?> </li>
	</ul>
</div>
