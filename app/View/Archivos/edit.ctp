<div class="archivos form">
<?php echo $this->Form->create('Archivo'); ?>
	<fieldset>
		<legend><?php echo __('Edit Archivo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('leccion');
		echo $this->Form->input('ruta');
		echo $this->Form->input('categorias_archivo_id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Archivo.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Archivo.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Archivos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Categorias Archivos'), array('controller' => 'categorias_archivos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Categorias Archivo'), array('controller' => 'categorias_archivos', 'action' => 'add')); ?> </li>
	</ul>
</div>
