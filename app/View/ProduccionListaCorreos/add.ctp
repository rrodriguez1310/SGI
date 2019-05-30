<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('ProduccionListaCorreo', array('class' => 'form-horizontal')); ?>
		<h4><?php echo __('Registrar Lista Correo'); ?></h4>
		
		<div class="form-group">
			<label class="col-md-2 control-label baja">Lista Correo</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('nombre', array("class"=>"form-control", "placeholder"=>"Ingrese Nombre", "label"=>false, "required"=>"required", 'maxlength'=>'100'));?>
			</div>
		</div>

		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>
$('#ProduccionListaCorreoAddForm').submit(function () {
	if($(this).valid()){
		$("#submit").prop("disabled",true);
		$("#safe").click();
	}
});
</script>