<div class="montosFondoFijos view">
<h2><?php echo __('Montos Fondo Fijo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Titulo'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['titulo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Area'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['area']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['monto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Encargado'); ?></dt>
		<dd>
			<?php echo h($montosFondoFijo['MontosFondoFijo']['encargado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Montos Fondo Fijo'), array('action' => 'edit', $montosFondoFijo['MontosFondoFijo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Montos Fondo Fijo'), array('action' => 'delete', $montosFondoFijo['MontosFondoFijo']['id']), array(), __('Are you sure you want to delete # %s?', $montosFondoFijo['MontosFondoFijo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Montos Fondo Fijos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Montos Fondo Fijo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
