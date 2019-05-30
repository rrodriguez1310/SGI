<div class="produccionPartidosOptas form">
<?php echo $this->Form->create('ProduccionPartidosOpta'); ?>
	<fieldset>
		<legend><?php echo __('Edit Produccion Partidos Opta'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('opta_season_id');
		echo $this->Form->input('opta_competition_id');
		echo $this->Form->input('opta_game_id');
		echo $this->Form->input('produccion_partidos_evento_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ProduccionPartidosOpta.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('ProduccionPartidosOpta.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Produccion Partidos Optas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Produccion Partidos Eventos'), array('controller' => 'produccion_partidos_eventos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Produccion Partidos Evento'), array('controller' => 'produccion_partidos_eventos', 'action' => 'add')); ?> </li>
	</ul>
</div>
