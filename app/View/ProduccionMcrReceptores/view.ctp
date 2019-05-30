<div class="receptores view">
<h2><?php echo __('Receptore'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($receptore['Receptore']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($receptore['Receptore']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Transmision Medio Transmisione'); ?></dt>
		<dd>
			<?php echo $this->Html->link($receptore['TransmisionMedioTransmisione']['id'], array('controller' => 'transmision_medio_transmisiones', 'action' => 'view', $receptore['TransmisionMedioTransmisione']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Receptore'), array('action' => 'edit', $receptore['Receptore']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Receptore'), array('action' => 'delete', $receptore['Receptore']['id']), array(), __('Are you sure you want to delete # %s?', $receptore['Receptore']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Receptores'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Receptore'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Transmision Medio Transmisiones'), array('controller' => 'transmision_medio_transmisiones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Transmision Medio Transmisione'), array('controller' => 'transmision_medio_transmisiones', 'action' => 'add')); ?> </li>
	</ul>
</div>
