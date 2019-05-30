<div class="listaCorreosTipos view">
<h2><?php echo __('Lista Correos Tipo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($listaCorreosTipo['ListaCorreosTipo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($listaCorreosTipo['ListaCorreosTipo']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($listaCorreosTipo['ListaCorreosTipo']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($listaCorreosTipo['ListaCorreosTipo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($listaCorreosTipo['ListaCorreosTipo']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Lista Correos Tipo'), array('action' => 'edit', $listaCorreosTipo['ListaCorreosTipo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Lista Correos Tipo'), array('action' => 'delete', $listaCorreosTipo['ListaCorreosTipo']['id']), array(), __('Are you sure you want to delete # %s?', $listaCorreosTipo['ListaCorreosTipo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Lista Correos Tipos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lista Correos Tipo'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Lista Correos'), array('controller' => 'lista_correos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Lista Correo'), array('controller' => 'lista_correos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Lista Correos'); ?></h3>
	<?php if (!empty($listaCorreosTipo['ListaCorreo'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Descripcion'); ?></th>
		<th><?php echo __('Lista Correos Tipo Id'); ?></th>
		<th><?php echo __('Lista Correos Mensaje Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($listaCorreosTipo['ListaCorreo'] as $listaCorreo): ?>
		<tr>
			<td><?php echo $listaCorreo['id']; ?></td>
			<td><?php echo $listaCorreo['nombre']; ?></td>
			<td><?php echo $listaCorreo['descripcion']; ?></td>
			<td><?php echo $listaCorreo['lista_correos_tipo_id']; ?></td>
			<td><?php echo $listaCorreo['lista_correos_mensaje_id']; ?></td>
			<td><?php echo $listaCorreo['created']; ?></td>
			<td><?php echo $listaCorreo['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'lista_correos', 'action' => 'view', $listaCorreo['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'lista_correos', 'action' => 'edit', $listaCorreo['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'lista_correos', 'action' => 'delete', $listaCorreo['id']), array(), __('Are you sure you want to delete # %s?', $listaCorreo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Lista Correo'), array('controller' => 'lista_correos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
