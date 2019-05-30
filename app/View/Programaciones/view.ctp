<div class="programaciones view">
<h2><?php echo __('Programacione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Log Programa'); ?></dt>
		<dd>
			<?php echo $this->Html->link($programacione['LogPrograma']['id'], array('controller' => 'log_programas', 'action' => 'view', $programacione['LogPrograma']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Hora'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['hora']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Channel'); ?></dt>
		<dd>
			<?php echo $this->Html->link($programacione['Channel']['id'], array('controller' => 'channels', 'action' => 'view', $programacione['Channel']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($programacione['Programacione']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Programacione'), array('action' => 'edit', $programacione['Programacione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Programacione'), array('action' => 'delete', $programacione['Programacione']['id']), array(), __('Are you sure you want to delete # %s?', $programacione['Programacione']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Programaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Programacione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Log Programas'), array('controller' => 'log_programas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Log Programa'), array('controller' => 'log_programas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Channels'), array('controller' => 'channels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Channel'), array('controller' => 'channels', 'action' => 'add')); ?> </li>
	</ul>
</div>
