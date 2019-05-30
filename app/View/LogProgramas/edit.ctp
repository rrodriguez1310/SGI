<div class="logProgramas form">
<?php echo $this->Form->create('LogPrograma'); ?>
	<fieldset>
		<legend><?php echo __('Edit Log Programa'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('numero_evento');
		echo $this->Form->input('fecha');
		echo $this->Form->input('inicio_presupuestado');
		echo $this->Form->input('nombre_canal');
		echo $this->Form->input('tipo_play');
		echo $this->Form->input('hora_inicio');
		echo $this->Form->input('hora_inicio_dos');
		echo $this->Form->input('duracion');
		echo $this->Form->input('hora_tres');
		echo $this->Form->input('clip');
		echo $this->Form->input('estado');
		echo $this->Form->input('path');
		echo $this->Form->input('nombre_archivo');
		echo $this->Form->input('prefijo');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('LogPrograma.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('LogPrograma.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Log Programas'), array('action' => 'index')); ?></li>
	</ul>
</div>
