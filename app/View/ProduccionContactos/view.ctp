<div class="produccionContactos view">
<h2><?php echo __('Produccion Contacto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($produccionContacto['ProduccionContacto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($produccionContacto['ProduccionContacto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($produccionContacto['ProduccionContacto']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($produccionContacto['ProduccionContacto']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Produccion Contacto'), array('action' => 'edit', $produccionContacto['ProduccionContacto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Produccion Contacto'), array('action' => 'delete', $produccionContacto['ProduccionContacto']['id']), array(), __('Are you sure you want to delete # %s?', $produccionContacto['ProduccionContacto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Produccion Contactos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Produccion Contacto'), array('action' => 'add')); ?> </li>
	</ul>
</div>
