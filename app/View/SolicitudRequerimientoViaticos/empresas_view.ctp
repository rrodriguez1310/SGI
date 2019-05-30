<div class="solicitudRequerimientoViaticos view">
<h2><?php echo __('Solicitud Requerimiento Viatico'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Inicio'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['fecha_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora Inicio'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['hora_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Termino'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['fecha_termino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora Termino'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['hora_termino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Responsable'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['responsable']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Moneda'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['tipo_moneda']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Titulo'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['titulo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Url Documento'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['url_documento']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observacion'); ?></dt>
		<dd>
			<?php echo h($solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['observacion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Solicitud Requerimiento Viatico'), array('action' => 'edit', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Solicitud Requerimiento Viatico'), array('action' => 'delete', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id']), array(), __('Are you sure you want to delete # %s?', $solicitudRequerimientoViatico['SolicitudRequerimientoViatico']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Solicitud Requerimiento Viaticos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Solicitud Requerimiento Viatico'), array('action' => 'add')); ?> </li>
	</ul>
</div>
