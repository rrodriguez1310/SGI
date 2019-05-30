<div class="programacionesCodigos view">
<h2><?php echo __('Programaciones Codigo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Titulo'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['titulo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiempo Aproximado'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['tiempo_aproximado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tiempo'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['tiempo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Familia'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['familia']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($programacionesCodigo['ProgramacionesCodigo']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Programaciones Codigo'), array('action' => 'edit', $programacionesCodigo['ProgramacionesCodigo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Programaciones Codigo'), array('action' => 'delete', $programacionesCodigo['ProgramacionesCodigo']['id']), array(), __('Are you sure you want to delete # %s?', $programacionesCodigo['ProgramacionesCodigo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Programaciones Codigos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Programaciones Codigo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
