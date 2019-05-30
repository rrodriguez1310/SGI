<div class="categoriasArchivos form">
<?php echo $this->Form->create('CategoriasArchivo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Categorias Archivo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre');
		echo $this->Form->input('ruta');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CategoriasArchivo.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('CategoriasArchivo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Categorias Archivos'), array('action' => 'index')); ?></li>
	</ul>
</div>
