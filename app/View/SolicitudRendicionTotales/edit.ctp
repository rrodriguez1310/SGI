<!--div class="solicitudRendicionTotales form">
<?php echo $this->Form->create('SolicitudRendicionTotale'); ?>
	<fieldset>
		<legend><?php echo __('Edit Solicitud Rendicion Totale'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('fecha_documento');
		echo $this->Form->input('n_solicitud_folio');
		echo $this->Form->input('monto');
		echo $this->Form->input('titulo');
		echo $this->Form->input('url_documento');
		echo $this->Form->input('observacion');
		echo $this->Form->input('total');
		echo $this->Form->input('tipos_moneda_id');
		echo $this->Form->input('tipo_fondo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SolicitudRendicionTotale.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('SolicitudRendicionTotale.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Solicitud Rendicion Totales'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tipos Monedas'), array('controller' => 'tipos_monedas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipos Moneda'), array('controller' => 'tipos_monedas', 'action' => 'add')); ?> </li>
	</ul>
</div-->
