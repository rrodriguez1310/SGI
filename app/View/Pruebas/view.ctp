<div class="pruebas view">
<h2><?php echo __('Prueba'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Titulo'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['titulo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descripcion'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['descripcion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Numero Preguntas'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['numero_preguntas']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Punt Max'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['punt_max']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Punt Min'); ?></dt>
		<dd>
			<?php echo h($prueba['Prueba']['punt_min']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Prueba'), array('action' => 'edit', $prueba['Prueba']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Prueba'), array('action' => 'delete', $prueba['Prueba']['id']), array(), __('Are you sure you want to delete # %s?', $prueba['Prueba']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pruebas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Prueba'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calificaciones'), array('controller' => 'calificaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calificacione'), array('controller' => 'calificaciones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Preguntas'), array('controller' => 'preguntas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pregunta'), array('controller' => 'preguntas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Calificaciones'); ?></h3>
	<?php if (!empty($prueba['Calificacione'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Calificacion'); ?></th>
		<th><?php echo __('Porcentaje'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Fecha'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Prueba Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($prueba['Calificacione'] as $calificacione): ?>
		<tr>
			<td><?php echo $calificacione['id']; ?></td>
			<td><?php echo $calificacione['calificacion']; ?></td>
			<td><?php echo $calificacione['porcentaje']; ?></td>
			<td><?php echo $calificacione['estado']; ?></td>
			<td><?php echo $calificacione['fecha']; ?></td>
			<td><?php echo $calificacione['user_id']; ?></td>
			<td><?php echo $calificacione['prueba_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'calificaciones', 'action' => 'view', $calificacione['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'calificaciones', 'action' => 'edit', $calificacione['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'calificaciones', 'action' => 'delete', $calificacione['id']), array(), __('Are you sure you want to delete # %s?', $calificacione['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Calificacione'), array('controller' => 'calificaciones', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Preguntas'); ?></h3>
	<?php if (!empty($prueba['Pregunta'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Pregunta'); ?></th>
		<th><?php echo __('Respuesta'); ?></th>
		<th><?php echo __('Numero Pregunta'); ?></th>
		<th><?php echo __('Prueba Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($prueba['Pregunta'] as $pregunta): ?>
		<tr>
			<td><?php echo $pregunta['id']; ?></td>
			<td><?php echo $pregunta['pregunta']; ?></td>
			<td><?php echo $pregunta['respuesta']; ?></td>
			<td><?php echo $pregunta['numero_pregunta']; ?></td>
			<td><?php echo $pregunta['prueba_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'preguntas', 'action' => 'view', $pregunta['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'preguntas', 'action' => 'edit', $pregunta['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'preguntas', 'action' => 'delete', $pregunta['id']), array(), __('Are you sure you want to delete # %s?', $pregunta['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pregunta'), array('controller' => 'preguntas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
