<div class="solicitudRequerimientoViaticos form">
<?php echo $this->Form->create('SolicitudRequerimientoViatico'); ?>
	<fieldset>
		<legend><?php echo __('Empresas Add Solicitud Requerimiento Viatico'); ?></legend>
	<?php
		echo $this->Form->input('fecha_inicio');
		echo $this->Form->input('hora_inicio');
		echo $this->Form->input('fecha_termino');
		echo $this->Form->input('hora_termino');
		echo $this->Form->input('responsable');
		echo $this->Form->input('tipo_moneda');
		echo $this->Form->input('titulo');
		echo $this->Form->input('url_documento');
		echo $this->Form->input('observacion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Solicitud Requerimiento Viaticos'), array('action' => 'index')); ?></li>
	</ul>
</div>
