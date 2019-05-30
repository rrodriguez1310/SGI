<div class="solicitudRequerimientoViaticos form">
<?php echo $this->Form->create('SolicitudRequerimientoViatico'); ?>
	<fieldset>
		<legend><?php echo __('Empresas Edit Solicitud Requerimiento Viatico'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SolicitudRequerimientoViatico.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('SolicitudRequerimientoViatico.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Solicitud Requerimiento Viaticos'), array('action' => 'index')); ?></li>
	</ul>
</div>
