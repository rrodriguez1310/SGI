<div class="archivos view">
<h2><?php echo __('Archivo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($archivo['Archivo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Leccion'); ?></dt>
		<dd>
			<?php echo h($archivo['Archivo']['leccion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ruta'); ?></dt>
		<dd>
			<?php echo h($archivo['Archivo']['ruta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Categorias Archivo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($archivo['CategoriasArchivo']['id'], array('controller' => 'categorias_archivos', 'action' => 'view', $archivo['CategoriasArchivo']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($archivo['Archivo']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Archivo'), array('action' => 'edit', $archivo['Archivo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Archivo'), array('action' => 'delete', $archivo['Archivo']['id']), array(), __('Are you sure you want to delete # %s?', $archivo['Archivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Archivos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Archivo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Categorias Archivos'), array('controller' => 'categorias_archivos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categorias Archivo'), array('controller' => 'categorias_archivos', 'action' => 'add')); ?> </li>
	</ul>
</div>
