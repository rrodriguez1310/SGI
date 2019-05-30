<div class="companiesAttributes view">
<h2><?php echo __('Companies Attribute'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($companiesAttribute['CompaniesAttribute']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Company'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesAttribute['Company']['id'], array('controller' => 'companies', 'action' => 'view', $companiesAttribute['Company']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Channel'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesAttribute['Channel']['id'], array('controller' => 'channels', 'action' => 'view', $companiesAttribute['Channel']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Link'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesAttribute['Link']['id'], array('controller' => 'links', 'action' => 'view', $companiesAttribute['Link']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Signal'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesAttribute['Signal']['id'], array('controller' => 'signals', 'action' => 'view', $companiesAttribute['Signal']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payment'); ?></dt>
		<dd>
			<?php echo $this->Html->link($companiesAttribute['Payment']['id'], array('controller' => 'payments', 'action' => 'view', $companiesAttribute['Payment']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($companiesAttribute['CompaniesAttribute']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($companiesAttribute['CompaniesAttribute']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Companies Attribute'), array('action' => 'edit', $companiesAttribute['CompaniesAttribute']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Companies Attribute'), array('action' => 'delete', $companiesAttribute['CompaniesAttribute']['id']), array(), __('Are you sure you want to delete # %s?', $companiesAttribute['CompaniesAttribute']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies Attributes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Companies Attribute'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Companies'), array('controller' => 'companies', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Company'), array('controller' => 'companies', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Channels'), array('controller' => 'channels', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Channel'), array('controller' => 'channels', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Links'), array('controller' => 'links', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Link'), array('controller' => 'links', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Signals'), array('controller' => 'signals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Signal'), array('controller' => 'signals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payments'), array('controller' => 'payments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment'), array('controller' => 'payments', 'action' => 'add')); ?> </li>
	</ul>
</div>
