<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('CatalogacionRTipo', array('class' => 'form-horizontal')); ?>
			<h4><?php echo __('Registrar Tipo Requerimiento'); ?></h4>
			<br/>
			<?php echo $this->Form->input('id'); ?>
			<div class="form-group">
				<label class="col-md-2 control-label baja"><span class="aterisco">*</span>Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array('type'=>'text',"class"=>"form-control requerido", "placeholder"=>"Tipo Requerimiento", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"Nombre"));?>
				</div>
			</div>
			<?php echo $this->Form->hidden('tipo', array("default"=>1));?>
		<br>
		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>
	$('#CatalogacionRTipoEditForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
			$("#safe").click();
		}
	});
</script>