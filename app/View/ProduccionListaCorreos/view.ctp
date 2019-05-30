<div class="produccionListaCorreos view">
<h2><?php echo __('Produccion Lista Correo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($produccionListaCorreo['ProduccionListaCorreo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($produccionListaCorreo['ProduccionListaCorreo']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contactos'); ?></dt>
		<dd>
			<?php echo h($produccionListaCorreo['ProduccionListaCorreo']['contactos']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($produccionListaCorreo['ProduccionListaCorreo']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Produccion Lista Correo'), array('action' => 'edit', $produccionListaCorreo['ProduccionListaCorreo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Produccion Lista Correo'), array('action' => 'delete', $produccionListaCorreo['ProduccionListaCorreo']['id']), array(), __('Are you sure you want to delete # %s?', $produccionListaCorreo['ProduccionListaCorreo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Produccion Lista Correos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Produccion Lista Correo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
