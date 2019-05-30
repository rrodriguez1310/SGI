<div class="companiesComentarios form">
<?php echo $this->Form->create('CompaniesComentario'); ?>
	<fieldset>
		<legend><?php echo __('Add Companies Comentario'); ?></legend>
	<?php
		echo $this->Form->input('company_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('clasificacion_comentario_id');
		echo $this->Form->input('comentario');
		echo $this->Form->input('estado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Companies Comentarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clasificacion Comentarios'), array('controller' => 'clasificacion_comentarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clasificacion Comentario'), array('controller' => 'clasificacion_comentarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
