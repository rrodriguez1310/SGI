<div class="clasificacionComentarios view">
<h2><?php echo __('Clasificacion Comentario'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($clasificacionComentario['ClasificacionComentario']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Clasificacion'); ?></dt>
		<dd>
			<?php echo h($clasificacionComentario['ClasificacionComentario']['clasificacion']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Clasificacion Comentario'), array('action' => 'edit', $clasificacionComentario['ClasificacionComentario']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Clasificacion Comentario'), array('action' => 'delete', $clasificacionComentario['ClasificacionComentario']['id']), array(), __('Are you sure you want to delete # %s?', $clasificacionComentario['ClasificacionComentario']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Clasificacion Comentarios'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Clasificacion Comentario'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies Comentarios'), array('controller' => 'companies_comentarios', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Companies Comentario'), array('controller' => 'companies_comentarios', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Companies Comentarios'); ?></h3>
	<?php if (!empty($clasificacionComentario['CompaniesComentario'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Company Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Clasificacion Comentario Id'); ?></th>
		<th><?php echo __('Comentario'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($clasificacionComentario['CompaniesComentario'] as $companiesComentario): ?>
		<tr>
			<td><?php echo $companiesComentario['id']; ?></td>
			<td><?php echo $companiesComentario['company_id']; ?></td>
			<td><?php echo $companiesComentario['user_id']; ?></td>
			<td><?php echo $companiesComentario['clasificacion_comentario_id']; ?></td>
			<td><?php echo $companiesComentario['comentario']; ?></td>
			<td><?php echo $companiesComentario['estado']; ?></td>
			<td><?php echo $companiesComentario['created']; ?></td>
			<td><?php echo $companiesComentario['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'companies_comentarios', 'action' => 'view', $companiesComentario['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'companies_comentarios', 'action' => 'edit', $companiesComentario['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'companies_comentarios', 'action' => 'delete', $companiesComentario['id']), array(), __('Are you sure you want to delete # %s?', $companiesComentario['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Companies Comentario'), array('controller' => 'companies_comentarios', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
