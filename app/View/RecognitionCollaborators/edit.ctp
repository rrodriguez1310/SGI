<div class="recognitionCollaborators form">
<?php echo $this->Form->create('RecognitionCollaborator'); ?>
	<fieldset>
		<legend><?php echo __('Edit Recognition Collaborator'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('subconducts_id');
		echo $this->Form->input('boss_id');
		echo $this->Form->input('employed_id');
		echo $this->Form->input('points_add');
		echo $this->Form->input('points_delete');
		echo $this->Form->input('change');
		echo $this->Form->input('product_id');
		echo $this->Form->input('descrption');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RecognitionCollaborator.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('RecognitionCollaborator.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Recognition Collaborators'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Recognition Subconducts'), array('controller' => 'recognition_subconducts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subconducts'), array('controller' => 'recognition_subconducts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Boss Departaments'), array('controller' => 'recognition_boss_departaments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Boss'), array('controller' => 'recognition_boss_departaments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trabajadores'), array('controller' => 'trabajadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employed'), array('controller' => 'trabajadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Products'), array('controller' => 'recognition_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'recognition_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
