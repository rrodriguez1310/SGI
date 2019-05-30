<div class="induccionQuizzes index">
	<h2><?php echo __('Induccion Quizzes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('induccion_pregunta_id'); ?></th>
			<th><?php echo $this->Paginator->sort('induccion_respuesta_id'); ?></th>
			<th><?php echo $this->Paginator->sort('induccion_etapa_id'); ?></th>
			<th><?php echo $this->Paginator->sort('otro'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($induccionQuizzes as $induccionQuiz): ?>
	<tr>
		<td><?php echo h($induccionQuiz['InduccionQuiz']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($induccionQuiz['InduccionPregunta']['pregunta'], array('controller' => 'induccion_preguntas', 'action' => 'view', $induccionQuiz['InduccionPregunta']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($induccionQuiz['InduccionRespuesta']['respuesta'], array('controller' => 'induccion_respuestas', 'action' => 'view', $induccionQuiz['InduccionRespuesta']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($induccionQuiz['InduccionEtapa']['titulo'], array('controller' => 'induccion_etapas', 'action' => 'view', $induccionQuiz['InduccionEtapa']['id'])); ?>
		</td>
		<td><?php echo h($induccionQuiz['InduccionQuiz']['otro']); ?>&nbsp;</td>
		<td><?php echo h($induccionQuiz['InduccionQuiz']['created']); ?>&nbsp;</td>
		<td><?php echo h($induccionQuiz['InduccionQuiz']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $induccionQuiz['InduccionQuiz']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $induccionQuiz['InduccionQuiz']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $induccionQuiz['InduccionQuiz']['id']), array(), __('Are you sure you want to delete # %s?', $induccionQuiz['InduccionQuiz']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Induccion Quiz'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Induccion Preguntas'), array('controller' => 'induccion_preguntas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Pregunta'), array('controller' => 'induccion_preguntas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Respuestas'), array('controller' => 'induccion_respuestas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Respuesta'), array('controller' => 'induccion_respuestas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Induccion Etapas'), array('controller' => 'induccion_etapas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Induccion Etapa'), array('controller' => 'induccion_etapas', 'action' => 'add')); ?> </li>
	</ul>
</div>
