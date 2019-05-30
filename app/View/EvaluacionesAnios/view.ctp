<div class="evaluacionesAnios view">
<h2><?php echo __('Evaluaciones Anio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Anio Evaluado'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['anio_evaluado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Inicio'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['fecha_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Termino'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['fecha_termino']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Evaluar'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['evaluar']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($evaluacionesAnio['EvaluacionesAnio']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Evaluaciones Anio'), array('action' => 'edit', $evaluacionesAnio['EvaluacionesAnio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Evaluaciones Anio'), array('action' => 'delete', $evaluacionesAnio['EvaluacionesAnio']['id']), array(), __('Are you sure you want to delete # %s?', $evaluacionesAnio['EvaluacionesAnio']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Evaluaciones Anios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Evaluaciones Anio'), array('action' => 'add')); ?> </li>
	</ul>
</div>
