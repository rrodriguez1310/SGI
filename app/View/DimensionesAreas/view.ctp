<div class="dimensionesAreas view">
<h2><?php echo __('Dimensiones Area'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($dimensionesArea['DimensionesArea']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($dimensionesArea['DimensionesArea']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Dimensiones Area'), array('action' => 'edit', $dimensionesArea['DimensionesArea']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Dimensiones Area'), array('action' => 'delete', $dimensionesArea['DimensionesArea']['id']), array(), __('Are you sure you want to delete # %s?', $dimensionesArea['DimensionesArea']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Dimensiones Areas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Dimensiones Area'), array('action' => 'add')); ?> </li>
	</ul>
</div>
