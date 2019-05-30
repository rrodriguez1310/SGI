<div class="calificaciones view">
<h2><?php echo __('Calificacione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calificacione['Calificacione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Calificacion'); ?></dt>
		<dd>
			<?php echo h($calificacione['Calificacione']['calificacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Porcentaje'); ?></dt>
		<dd>
			<?php echo h($calificacione['Calificacione']['porcentaje']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($calificacione['Calificacione']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($calificacione['Calificacione']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($calificacione['User']['id'], array('controller' => 'users', 'action' => 'view', $calificacione['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prueba'); ?></dt>
		<dd>
			<?php echo $this->Html->link($calificacione['Prueba']['id'], array('controller' => 'pruebas', 'action' => 'view', $calificacione['Prueba']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calificacione'), array('action' => 'edit', $calificacione['Calificacione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calificacione'), array('action' => 'delete', $calificacione['Calificacione']['id']), array(), __('Are you sure you want to delete # %s?', $calificacione['Calificacione']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calificaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calificacione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pruebas'), array('controller' => 'pruebas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Prueba'), array('controller' => 'pruebas', 'action' => 'add')); ?> </li>
	</ul>
</div>
