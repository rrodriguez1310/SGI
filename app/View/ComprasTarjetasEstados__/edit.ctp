<div class="comprasTarjetasEstados form">
<?php echo $this->Form->create('ComprasTarjetasEstado'); ?>
	<fieldset>
		<legend><?php echo __('Edit Compras Tarjetas Estado'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ComprasTarjetasEstado.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ComprasTarjetasEstado.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Compras Tarjetas Estados'), array('action' => 'index')); ?></li>
	</ul>
</div>
