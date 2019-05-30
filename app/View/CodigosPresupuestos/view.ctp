<div class="codigosPresupuestos view">
<h2><?php echo __('Codigos Presupuesto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Total'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_total']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Enero'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_enero']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Febrero'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_febrero']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Marzo'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_marzo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Abril'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_abril']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Mayo'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_mayo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Junio'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_junio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Julio'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_julio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Agosto'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_agosto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Septiembre'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_septiembre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Octubre'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_octubre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Noviembre'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_noviembre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Presupuesto Diciembre'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['presupuesto_diciembre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Codigo'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['codigo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Year'); ?></dt>
		<dd>
			<?php echo $this->Html->link($codigosPresupuesto['Year']['id'], array('controller' => 'years', 'action' => 'view', $codigosPresupuesto['Year']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($codigosPresupuesto['CodigosPresupuesto']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Codigos Presupuesto'), array('action' => 'edit', $codigosPresupuesto['CodigosPresupuesto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Codigos Presupuesto'), array('action' => 'delete', $codigosPresupuesto['CodigosPresupuesto']['id']), array(), __('Are you sure you want to delete # %s?', $codigosPresupuesto['CodigosPresupuesto']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Codigos Presupuestos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Codigos Presupuesto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Years'), array('controller' => 'years', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Year'), array('controller' => 'years', 'action' => 'add')); ?> </li>
	</ul>
</div>
