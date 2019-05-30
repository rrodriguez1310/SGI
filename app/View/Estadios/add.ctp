<div class="estadios form">
<?php echo $this->Form->create('Estadio'); ?>
	<fieldset>
		<legend><?php echo __('Add Estadio'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
		echo $this->Form->input('ciudad');
		echo $this->Form->input('localia');
		echo $this->Form->input('divisione_id');
		echo $this->Form->input('localia_equipo_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Estadios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Localia Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
