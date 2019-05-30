<div class="recognitionCollaborators view">
<h2><?php echo __('Recognition Collaborator'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subconducts'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recognitionCollaborator['Subconducts']['name'], array('controller' => 'recognition_subconducts', 'action' => 'view', $recognitionCollaborator['Subconducts']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Boss'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recognitionCollaborator['Boss']['id'], array('controller' => 'recognition_boss_departaments', 'action' => 'view', $recognitionCollaborator['Boss']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Employed'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recognitionCollaborator['Employed']['id'], array('controller' => 'trabajadores', 'action' => 'view', $recognitionCollaborator['Employed']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Points Add'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['points_add']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Points Delete'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['points_delete']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Change'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['change']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Product'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recognitionCollaborator['Product']['name'], array('controller' => 'recognition_products', 'action' => 'view', $recognitionCollaborator['Product']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descrption'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['descrption']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($recognitionCollaborator['RecognitionCollaborator']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recognition Collaborator'), array('action' => 'edit', $recognitionCollaborator['RecognitionCollaborator']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recognition Collaborator'), array('action' => 'delete', $recognitionCollaborator['RecognitionCollaborator']['id']), array(), __('Are you sure you want to delete # %s?', $recognitionCollaborator['RecognitionCollaborator']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Collaborators'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recognition Collaborator'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Subconducts'), array('controller' => 'recognition_subconducts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subconducts'), array('controller' => 'recognition_subconducts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Boss Departaments'), array('controller' => 'recognition_boss_departaments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Boss'), array('controller' => 'recognition_boss_departaments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Trabajadores'), array('controller' => 'trabajadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Employed'), array('controller' => 'trabajadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Products'), array('controller' => 'recognition_products', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Product'), array('controller' => 'recognition_products', 'action' => 'add')); ?> </li>
	</ul>
</div>
