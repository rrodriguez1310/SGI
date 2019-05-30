<div class="solicitudRequerimientoViaticos index">
	<h2><?php echo __('Solicitud Requerimiento Viaticos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('hora_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_termino'); ?></th>
			<th><?php echo $this->Paginator->sort('hora_termino'); ?></th>
			<th><?php echo $this->Paginator->sort('responsable'); ?></th>
			<th><?php echo $this->Paginator->sort('tipo_moneda'); ?></th>
			<th><?php echo $this->Paginator->sort('titulo'); ?></th>
			<th><?php echo $this->Paginator->sort('url_documento'); ?></th>
			<th><?php echo $this->Paginator->sort('observacion'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($solicitudRequerimientoViaticos as $solicitudRequerimientoViatico): ?>
	<tr>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['fecha_inicio']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['hora_inicio']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['fecha_termino']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['hora_termino']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['responsable']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['tipo_moneda']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['titulo']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['url_documento']); ?>&nbsp;</td>
		<td><?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['observacion']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id']), array(), __('Are you sure you want to delete # %s?', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Solicitud Requerimiento Viatico'), array('action' => 'add')); ?></li>
	</ul>
</div>
