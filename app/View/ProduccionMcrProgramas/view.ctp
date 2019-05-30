<div class="programas view">
<h2><?php echo __('Programa'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($programa['Programa']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($programa['Programa']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo'); ?></dt>
		<dd>
			<?php echo h($programa['Programa']['tipo']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Programa'), array('action' => 'edit', $programa['Programa']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Programa'), array('action' => 'delete', $programa['Programa']['id']), array(), __('Are you sure you want to delete # %s?', $programa['Programa']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Programas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Programa'), array('action' => 'add')); ?> </li>
	</ul>
</div>
