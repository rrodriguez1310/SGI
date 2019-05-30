<div class="preguntas view">
<h2><?php echo __('Pregunta'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pregunta['Pregunta']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pregunta'); ?></dt>
		<dd>
			<?php echo h($pregunta['Pregunta']['pregunta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Respuesta'); ?></dt>
		<dd>
			<?php echo h($pregunta['Pregunta']['respuesta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Prueba'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pregunta['Prueba']['id'], array('controller' => 'pruebas', 'action' => 'view', $pregunta['Prueba']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero Pregunta'); ?></dt>
		<dd>
			<?php echo h($pregunta['Pregunta']['numero_pregunta']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pregunta'), array('action' => 'edit', $pregunta['Pregunta']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pregunta'), array('action' => 'delete', $pregunta['Pregunta']['id']), array(), __('Are you sure you want to delete # %s?', $pregunta['Pregunta']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Preguntas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pregunta'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Pruebas'), array('controller' => 'pruebas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Prueba'), array('controller' => 'pruebas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Respuestas'), array('controller' => 'respuestas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Respuesta'), array('controller' => 'respuestas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Respuestas'); ?></h3>
	<?php if (!empty($pregunta['Respuesta'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Opcion Letra'); ?></th>
		<th><?php echo __('Opcion Text'); ?></th>
		<th><?php echo __('Pregunta Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pregunta['Respuesta'] as $respuesta): ?>
		<tr>
			<td><?php echo $respuesta['id']; ?></td>
			<td><?php echo $respuesta['opcion_letra']; ?></td>
			<td><?php echo $respuesta['opcion_text']; ?></td>
			<td><?php echo $respuesta['pregunta_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'respuestas', 'action' => 'view', $respuesta['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'respuestas', 'action' => 'edit', $respuesta['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'respuestas', 'action' => 'delete', $respuesta['id']), array(), __('Are you sure you want to delete # %s?', $respuesta['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Respuesta'), array('controller' => 'respuestas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
