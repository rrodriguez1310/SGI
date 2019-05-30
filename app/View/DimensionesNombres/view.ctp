<div class="dimensionesNombres view">
<h2><?php echo __('Dimensiones Nombre'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionesNombre['DimensionesNombre']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($dimensionesNombre['DimensionesNombre']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimensiones Nombre'), array('action' => 'edit', $dimensionesNombre['DimensionesNombre']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimensiones Nombre'), array('action' => 'delete', $dimensionesNombre['DimensionesNombre']['id']), array(), __('Are you sure you want to delete # %s?', $dimensionesNombre['DimensionesNombre']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimensiones Nombres'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimensiones Nombre'), array('action' => 'add')); ?> </li>
	</ul>
</div>
