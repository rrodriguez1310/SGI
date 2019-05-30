
<div class="col-md-6">
	<div class="form-group">
		<?php echo $this->Form->hidden('company_id', array('type'=>'text', 'label'=>false));?>
	</div>
	
	<div class="form-group">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<?php echo $this->Form->input('channel_id', array('label'=>false, 'class'=>'multiselect channel', "multiple"=>"multiple")); ?>
	</div>
	
	<div class="form-group">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<?php echo $this->Form->input('link_id', array('label'=>false, 'class'=>'multiselect link', "multiple"=>"multiple")); ?>
	</div>
	
	<div class="form-group">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<?php echo $this->Form->input('signal_id', array('label'=>false, 'class'=>'multiselect signal', "multiple"=>"multiple")); ?>
	</div>
	
	<div class="form-group">
		<label class="sr-only" for="exampleInputEmail2">Email address</label>
		<?php echo $this->Form->input('payment_id', array('label'=>false, 'class'=>'multiselect payment', "multiple"=>"multiple")); ?>
		</div>	
</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary registraAtributos">Registrar</button>
  </div>