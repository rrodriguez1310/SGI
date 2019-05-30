<div class="recognitionStatuses view">
<h2><?php echo __('Recognition Status'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recognitionStatus['RecognitionStatus']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($recognitionStatus['RecognitionStatus']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($recognitionStatus['RecognitionStatus']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($recognitionStatus['RecognitionStatus']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recognition Status'), array('action' => 'edit', $recognitionStatus['RecognitionStatus']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recognition Status'), array('action' => 'delete', $recognitionStatus['RecognitionStatus']['id']), array(), __('Are you sure you want to delete # %s?', $recognitionStatus['RecognitionStatus']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Recognition Statuses'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recognition Status'), array('action' => 'add')); ?> </li>
	</ul>
</div>
