<div class="companiesContactos index">
	<h2><?php echo __('Companies Contactos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('company_id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('apellido_paterno'); ?></th>
			<th><?php echo $this->Paginator->sort('apellido_materno'); ?></th>
			<th><?php echo $this->Paginator->sort('cargo'); ?></th>
			<th><?php echo $this->Paginator->sort('telefono_fijo'); ?></th>
			<th><?php echo $this->Paginator->sort('telefono_celular'); ?></th>
			<th><?php echo $this->Paginator->sort('observacion'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($companiesContactos as $companiesContacto): ?>
	<tr>
		<td><?php echo h($companiesContacto['CompaniesContacto']['id']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['email']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($companiesContacto['Company']['id'], array('controller' => 'companies', 'action' => 'view', $companiesContacto['Company']['id'])); ?>
		</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['created']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['modified']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['apellido_paterno']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['apellido_materno']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['cargo']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['telefono_fijo']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['telefono_celular']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['observacion']); ?>&nbsp;</td>
		<td><?php echo h($companiesContacto['CompaniesContacto']['estado']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $companiesContacto['CompaniesContacto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $companiesContacto['CompaniesContacto']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $companiesContacto['CompaniesContacto']['id']), array(), __('Are you sure you want to delete # %s?', $companiesContacto['CompaniesContacto']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Companies Contacto'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
	</ul>
</div>
