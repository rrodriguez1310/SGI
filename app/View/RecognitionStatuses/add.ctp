<div class="recognitionStatuses form">
<?php echo $this->Form->create('RecognitionStatus'); ?>
	<fieldset>
		<legend><?php echo __('Add Recognition Status'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Recognition Statuses'), array('action' => 'index')); ?></li>
	</ul>
</div>
