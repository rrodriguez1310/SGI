<div class="calificaciones form">
<?php echo $this->Form->create('Calificacione'); ?>
	<fieldset>
		<legend><?php echo __('Add Calificacione'); ?></legend>
	<?php
		echo $this->Form->input('calificacion');
		echo $this->Form->input('porcentaje');
		echo $this->Form->input('estado');
		echo $this->Form->input('fecha');
		echo $this->Form->input('user_id');
		echo $this->Form->input('prueba_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Calificaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pruebas'), array('controller' => 'pruebas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Prueba'), array('controller' => 'pruebas', 'action' => 'add')); ?> </li>
	</ul>
</div>
