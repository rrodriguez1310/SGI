<div class="programaciones form">
<?php echo $this->Form->create('Programacione'); ?>
	<fieldset>
		<legend><?php echo __('Edit Programacione'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('log_programa_id');
		echo $this->Form->input('hora');
		echo $this->Form->input('fecha');
		echo $this->Form->input('nombre');
		echo $this->Form->input('channel_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Programacione.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Programacione.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Programaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Log Programas'), array('controller' => 'log_programas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Log Programa'), array('controller' => 'log_programas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Channels'), array('controller' => 'channels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Channel'), array('controller' => 'channels', 'action' => 'add')); ?> </li>
	</ul>
</div>
