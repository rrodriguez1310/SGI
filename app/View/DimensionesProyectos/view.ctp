<div class="dimensionesProyectos view">
<h2><?php echo __('Dimensiones Proyecto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Codigo'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['codigo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($dimensionesProyecto['DimensionesProyecto']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimensiones Proyecto'), array('action' => 'edit', $dimensionesProyecto['DimensionesProyecto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimensiones Proyecto'), array('action' => 'delete', $dimensionesProyecto['DimensionesProyecto']['id']), array(), __('Are you sure you want to delete # %s?', $dimensionesProyecto['DimensionesProyecto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimensiones Proyectos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimensiones Proyecto'), array('action' => 'add')); ?> </li>
	</ul>
</div>
