<div class="companiesComentarios index">
	<h2><?php echo __('Companies Comentarios'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('company_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('clasificacion_comentario_id'); ?></th>
			<th><?php echo $this->Paginator->sort('comentario'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($companiesComentarios as $companiesComentario): ?>
	<tr>
		<td><?php echo h($companiesComentario['CompaniesComentario']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($companiesComentario['Company']['id'], array('controller' => 'companies', 'action' => 'view', $companiesComentario['Company']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($companiesComentario['User']['id'], array('controller' => 'users', 'action' => 'view', $companiesComentario['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($companiesComentario['ClasificacionComentario']['id'], array('controller' => 'clasificacion_comentarios', 'action' => 'view', $companiesComentario['ClasificacionComentario']['id'])); ?>
		</td>
		<td><?php echo h($companiesComentario['CompaniesComentario']['comentario']); ?>&nbsp;</td>
		<td><?php echo h($companiesComentario['CompaniesComentario']['estado']); ?>&nbsp;</td>
		<td><?php echo h($companiesComentario['CompaniesComentario']['created']); ?>&nbsp;</td>
		<td><?php echo h($companiesComentario['CompaniesComentario']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $companiesComentario['CompaniesComentario']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $companiesComentario['CompaniesComentario']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $companiesComentario['CompaniesComentario']['id']), array(), __('Are you sure you want to delete # %s?', $companiesComentario['CompaniesComentario']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Companies Comentario'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clasificacion Comentarios'), array('controller' => 'clasificacion_comentarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clasificacion Comentario'), array('controller' => 'clasificacion_comentarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
