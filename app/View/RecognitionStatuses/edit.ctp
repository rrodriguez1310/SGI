<div class="recognitionStatuses form">
<?php echo $this->Form->create('RecognitionStatus'); ?>
	<fieldset>
		<legend><?php echo __('Edit Recognition Status'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('RecognitionStatus.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('RecognitionStatus.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Recognition Statuses'), array('action' => 'index')); ?></li>
	</ul>
</div>
