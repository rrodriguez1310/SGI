<div class="comprasTarjetasEstados form">
<?php echo $this->Form->create('ComprasTarjetasEstado'); ?>
	<fieldset>
		<legend><?php echo __('Add Compras Tarjetas Estado'); ?></legend>
	<?php
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Compras Tarjetas Estados'), array('action' => 'index')); ?></li>
	</ul>
</div>
