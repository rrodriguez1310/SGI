<div class="clasificacionComentarios form">
<?php echo $this->Form->create('ClasificacionComentario'); ?>
	<fieldset>
		<legend><?php echo __('Edit Clasificacion Comentario'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('clasificacion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ClasificacionComentario.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ClasificacionComentario.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Clasificacion Comentarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Companies Comentarios'), array('controller' => 'companies_comentarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Companies Comentario'), array('controller' => 'companies_comentarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
