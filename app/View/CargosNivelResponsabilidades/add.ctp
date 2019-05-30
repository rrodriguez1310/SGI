<div class="cargosNivelResponsabilidades form">
<?php echo $this->Form->create('CargosNivelResponsabilidade'); ?>
	<fieldset>
		<legend><?php echo __('Add Cargos Nivel Responsabilidade'); ?></legend>
	<?php
		echo $this->Form->input('nivel');
		echo $this->Form->input('estado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cargos Nivel Responsabilidades'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cargos'), array('controller' => 'cargos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cargo'), array('controller' => 'cargos', 'action' => 'add')); ?> </li>
	</ul>
</div>
