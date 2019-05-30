<div class="induccionQuizzes view">
<h2><?php echo __('Induccion Quiz'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($induccionQuiz['InduccionQuiz']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Induccion Pregunta'); ?></dt>
		<dd>
			<?php echo $this->Html->link($induccionQuiz['InduccionPregunta']['pregunta'], array('controller' => 'induccion_preguntas', 'action' => 'view', $induccionQuiz['InduccionPregunta']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Induccion Respuesta'); ?></dt>
		<dd>
			<?php echo $this->Html->link($induccionQuiz['InduccionRespuesta']['respuesta'], array('controller' => 'induccion_respuestas', 'action' => 'view', $induccionQuiz['InduccionRespuesta']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Induccion Etapa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($induccionQuiz['InduccionEtapa']['titulo'], array('controller' => 'induccion_etapas', 'action' => 'view', $induccionQuiz['InduccionEtapa']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Otro'); ?></dt>
		<dd>
			<?php echo h($induccionQuiz['InduccionQuiz']['otro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($induccionQuiz['InduccionQuiz']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($induccionQuiz['InduccionQuiz']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Induccion Quiz'), array('action' => 'edit', $induccionQuiz['InduccionQuiz']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Induccion Quiz'), array('action' => 'delete', $induccionQuiz['InduccionQuiz']['id']), array(), __('Are you sure you want to delete # %s?', $induccionQuiz['InduccionQuiz']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Quizzes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Quiz'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Preguntas'), array('controller' => 'induccion_preguntas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Pregunta'), array('controller' => 'induccion_preguntas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Respuestas'), array('controller' => 'induccion_respuestas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Respuesta'), array('controller' => 'induccion_respuestas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Etapas'), array('controller' => 'induccion_etapas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Etapa'), array('controller' => 'induccion_etapas', 'action' => 'add')); ?> </li>
	</ul>
</div>
