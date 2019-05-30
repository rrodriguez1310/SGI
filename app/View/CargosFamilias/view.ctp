<div class="cargosFamilias view">
<h2><?php echo __('Cargos Familia'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($cargosFamilia['CargosFamilia']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($cargosFamilia['CargosFamilia']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($cargosFamilia['CargosFamilia']['estado']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Cargos Familia'), array('action' => 'edit', $cargosFamilia['CargosFamilia']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Cargos Familia'), array('action' => 'delete', $cargosFamilia['CargosFamilia']['id']), array(), __('Are you sure you want to delete # %s?', $cargosFamilia['CargosFamilia']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Cargos Familias'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cargos Familia'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cargos'), array('controller' => 'cargos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cargo'), array('controller' => 'cargos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cargos'); ?></h3>
	<?php if (!empty($cargosFamilia['Cargo'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Gerencia Id'); ?></th>
		<th><?php echo __('Area Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Cargos Familia Id'); ?></th>
		<th><?php echo __('Cargos Nivel Responsabilidade Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($cargosFamilia['Cargo'] as $cargo): ?>
		<tr>
			<td><?php echo $cargo['id']; ?></td>
			<td><?php echo $cargo['nombre']; ?></td>
			<td><?php echo $cargo['gerencia_id']; ?></td>
			<td><?php echo $cargo['area_id']; ?></td>
			<td><?php echo $cargo['created']; ?></td>
			<td><?php echo $cargo['modified']; ?></td>
			<td><?php echo $cargo['estado']; ?></td>
			<td><?php echo $cargo['cargos_familia_id']; ?></td>
			<td><?php echo $cargo['cargos_nivel_responsabilidade_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cargos', 'action' => 'view', $cargo['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cargos', 'action' => 'edit', $cargo['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cargos', 'action' => 'delete', $cargo['id']), array(), __('Are you sure you want to delete # %s?', $cargo['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Cargo'), array('controller' => 'cargos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
