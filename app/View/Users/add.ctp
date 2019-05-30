<div id="mensaje"></div>
<div class="col-md-6 col-md-offset-3">
	<?php echo $this->Form->create('User'); ?>
		<fieldset>
			<h4><?php echo __('Registrar Usuario'); ?></h4>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('User.trabajadore_id', array("class"=>"select2", "label"=>false, "required"=>"required", "options"=>$trabajadores));?>
			</div>
			<br/>
			<div class="required-field-block"  class="col-xs-4" >
				<?php echo $this->Form->input('User.nombre', array("class"=>"select21", "label"=>false, "required"=>"required", "options"=>$usuarios));?>
			</div>
			<br/>
		</fieldset>
		<br/><br/><br/>
		<button class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> Registrar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
</div>

<?php echo $this->Form->end(); ?>
<script>
	
	$(".select2").select2({
		placeholder: "Busque trabajador",
		allowClear: true,
		width:'100%',
		minimumInputLength: -1
	});
	$(".select21").select2({
		placeholder: "Seleccione usuario correspondiente",
		allowClear: true,
		width:'100%',
		minimumInputLength: 3,
	});
	
</script>