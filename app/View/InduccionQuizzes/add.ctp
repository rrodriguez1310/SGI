<div class="induccionQuizzes form">
<?php echo $this->Form->create('InduccionQuiz'); ?>
	<fieldset>
		<legend><?php echo __('Add Induccion Quiz'); ?></legend>
	<?php
		echo $this->Form->input('induccion_pregunta_id');
		echo $this->Form->input('induccion_respuesta_id');
		echo $this->Form->input('induccion_etapa_id');
		echo $this->Form->input('otro');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Induccion Quizzes'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Induccion Preguntas'), array('controller' => 'induccion_preguntas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Pregunta'), array('controller' => 'induccion_preguntas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Respuestas'), array('controller' => 'induccion_respuestas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Respuesta'), array('controller' => 'induccion_respuestas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Etapas'), array('controller' => 'induccion_etapas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Etapa'), array('controller' => 'induccion_etapas', 'action' => 'add')); ?> </li>
	</ul>
</div>
