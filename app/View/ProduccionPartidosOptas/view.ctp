<div class="produccionPartidosOptas view">
<h2><?php echo __('Produccion Partidos Opta'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($produccionPartidosOpta['ProduccionPartidosOpta']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opta Season Id'); ?></dt>
		<dd>
			<?php echo h($produccionPartidosOpta['ProduccionPartidosOpta']['opta_season_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opta Competition Id'); ?></dt>
		<dd>
			<?php echo h($produccionPartidosOpta['ProduccionPartidosOpta']['opta_competition_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Opta Game Id'); ?></dt>
		<dd>
			<?php echo h($produccionPartidosOpta['ProduccionPartidosOpta']['opta_game_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Produccion Partidos Evento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($produccionPartidosOpta['ProduccionPartidosEvento']['id'], array('controller' => 'produccion_partidos_eventos', 'action' => 'view', $produccionPartidosOpta['ProduccionPartidosEvento']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Produccion Partidos Opta'), array('action' => 'edit', $produccionPartidosOpta['ProduccionPartidosOpta']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Produccion Partidos Opta'), array('action' => 'delete', $produccionPartidosOpta['ProduccionPartidosOpta']['id']), array(), __('Are you sure you want to delete # %s?', $produccionPartidosOpta['ProduccionPartidosOpta']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Produccion Partidos Optas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Produccion Partidos Opta'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Produccion Partidos Eventos'), array('controller' => 'produccion_partidos_eventos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Produccion Partidos Evento'), array('controller' => 'produccion_partidos_eventos', 'action' => 'add')); ?> </li>
	</ul>
</div>
