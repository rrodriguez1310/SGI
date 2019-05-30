<div class="estadios view">
<h2><?php echo __('Estadio'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($estadio['Estadio']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($estadio['Estadio']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ciudad'); ?></dt>
		<dd>
			<?php echo h($estadio['Estadio']['ciudad']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Localia'); ?></dt>
		<dd>
			<?php echo h($estadio['Estadio']['localia']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Divisione Id'); ?></dt>
		<dd>
			<?php echo h($estadio['Estadio']['divisione_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Localia Equipo'); ?></dt>
		<dd>
			<?php echo $this->Html->link($estadio['LocaliaEquipo']['id'], array('controller' => 'equipos', 'action' => 'view', $estadio['LocaliaEquipo']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Estadio'), array('action' => 'edit', $estadio['Estadio']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Estadio'), array('action' => 'delete', $estadio['Estadio']['id']), array(), __('Are you sure you want to delete # %s?', $estadio['Estadio']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Estadios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estadio'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Equipos'), array('controller' => 'equipos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Localia Equipo'), array('controller' => 'equipos', 'action' => 'add')); ?> </li>
	</ul>
</div>
