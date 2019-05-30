<div class="subscribers view">
<h2><?php echo __('Subscriber'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($subscriber['Subscriber']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subscriber['Company']['id'], array('controller' => 'companies', 'action' => 'view', $subscriber['Company']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Year'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subscriber['Year']['id'], array('controller' => 'years', 'action' => 'view', $subscriber['Year']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Month'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subscriber['Month']['id'], array('controller' => 'months', 'action' => 'view', $subscriber['Month']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cantidad Abonados'); ?></dt>
		<dd>
			<?php echo h($subscriber['Subscriber']['cantidad_abonados']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($subscriber['Subscriber']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($subscriber['Subscriber']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Subscriber'), array('action' => 'edit', $subscriber['Subscriber']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Subscriber'), array('action' => 'delete', $subscriber['Subscriber']['id']), array(), __('Are you sure you want to delete # %s?', $subscriber['Subscriber']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Subscribers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subscriber'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Years'), array('controller' => 'years', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Year'), array('controller' => 'years', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Months'), array('controller' => 'months', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Month'), array('controller' => 'months', 'action' => 'add')); ?> </li>
	</ul>
</div>
