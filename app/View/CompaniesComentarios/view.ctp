<div class="companiesComentarios view">
<h2><?php echo __('Companies Comentario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($companiesComentario['CompaniesComentario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesComentario['Company']['id'], array('controller' => 'companies', 'action' => 'view', $companiesComentario['Company']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesComentario['User']['id'], array('controller' => 'users', 'action' => 'view', $companiesComentario['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clasificacion Comentario'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesComentario['ClasificacionComentario']['id'], array('controller' => 'clasificacion_comentarios', 'action' => 'view', $companiesComentario['ClasificacionComentario']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comentario'); ?></dt>
		<dd>
			<?php echo h($companiesComentario['CompaniesComentario']['comentario']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($companiesComentario['CompaniesComentario']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($companiesComentario['CompaniesComentario']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($companiesComentario['CompaniesComentario']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Companies Comentario'), array('action' => 'edit', $companiesComentario['CompaniesComentario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Companies Comentario'), array('action' => 'delete', $companiesComentario['CompaniesComentario']['id']), array(), __('Are you sure you want to delete # %s?', $companiesComentario['CompaniesComentario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies Comentarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Companies Comentario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clasificacion Comentarios'), array('controller' => 'clasificacion_comentarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clasificacion Comentario'), array('controller' => 'clasificacion_comentarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
