<div class="categoriasArchivos form">
<?php echo $this->Form->create('CategoriasArchivo'); ?>
	<fieldset>
		<legend><?php echo __('Add Categorias Archivo'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('ruta');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Categorias Archivos'), array('action' => 'index')); ?></li>
	</ul>
</div>
