<div class="categoriasArchivos view">
<h2><?php echo __('Categorias Archivo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($categoriasArchivo['CategoriasArchivo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($categoriasArchivo['CategoriasArchivo']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ruta'); ?></dt>
		<dd>
			<?php echo h($categoriasArchivo['CategoriasArchivo']['ruta']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Categorias Archivo'), array('action' => 'edit', $categoriasArchivo['CategoriasArchivo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Categorias Archivo'), array('action' => 'delete', $categoriasArchivo['CategoriasArchivo']['id']), array(), __('Are you sure you want to delete # %s?', $categoriasArchivo['CategoriasArchivo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Categorias Archivos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categorias Archivo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
