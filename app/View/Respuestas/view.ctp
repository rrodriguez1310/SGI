<div class="respuestas view">
<h2><?php echo __('Respuesta'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($respuesta['Respuesta']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opcion Letra'); ?></dt>
		<dd>
			<?php echo h($respuesta['Respuesta']['opcion_letra']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opcion Text'); ?></dt>
		<dd>
			<?php echo h($respuesta['Respuesta']['opcion_text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pregunta'); ?></dt>
		<dd>
			<?php echo $this->Html->link($respuesta['Pregunta']['id'], array('controller' => 'preguntas', 'action' => 'view', $respuesta['Pregunta']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Respuesta'), array('action' => 'edit', $respuesta['Respuesta']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Respuesta'), array('action' => 'delete', $respuesta['Respuesta']['id']), array(), __('Are you sure you want to delete # %s?', $respuesta['Respuesta']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Respuestas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Respuesta'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Preguntas'), array('controller' => 'preguntas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pregunta'), array('controller' => 'preguntas', 'action' => 'add')); ?> </li>
	</ul>
</div>
