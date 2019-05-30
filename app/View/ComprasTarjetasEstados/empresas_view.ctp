<div class="comprasTarjetasEstados view">
<h2><?php echo __('Compras Tarjetas Estado'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($comprasTarjetasEstado['ComprasTarjetasEstado']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($comprasTarjetasEstado['ComprasTarjetasEstado']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Compras Tarjetas Estado'), array('action' => 'edit', $comprasTarjetasEstado['ComprasTarjetasEstado']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Compras Tarjetas Estado'), array('action' => 'delete', $comprasTarjetasEstado['ComprasTarjetasEstado']['id']), array(), __('Are you sure you want to delete # %s?', $comprasTarjetasEstado['ComprasTarjetasEstado']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Compras Tarjetas Estados'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Compras Tarjetas Estado'), array('action' => 'add')); ?> </li>
	</ul>
</div>
