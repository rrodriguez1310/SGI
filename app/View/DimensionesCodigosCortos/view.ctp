<div class="dimensionesCodigosCortos view">
<h2><?php echo __('Dimensiones Codigos Corto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($dimensionesCodigosCorto['DimensionesCodigosCorto']['descripcion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimensiones Codigos Corto'), array('action' => 'edit', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimensiones Codigos Corto'), array('action' => 'delete', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id']), array(), __('Are you sure you want to delete # %s?', $dimensionesCodigosCorto['DimensionesCodigosCorto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimensiones Codigos Cortos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimensiones Codigos Corto'), array('action' => 'add')); ?> </li>
	</ul>
</div>
