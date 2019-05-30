<div class="col-md-7 col-md-offset-3">
	<?php echo $this->Form->create('Area', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<h4 class="col-md-offset-2"><?php echo __('Edición de áreas'); ?></h4>
			<?php echo $this->Form->input('id');?>
			<div class="form-group">
				<label class="col-md-2 control-label">Gerencia</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('gerencia_id', array("class"=>"select2 mayuscula",'options' => $gerencias, "label"=>false, "required"=>"required"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label baja">Área</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese nombre área", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
		</fieldset>
		<br/><br/>
		<button class="btn btn-primary btn-lg col-md-offset-2"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
		<a href="<?php echo $this->Html->url(array("controller"=>"areas", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
	<?php echo $this->Form->end(); ?>
</div>

<script>
	
	$(".select2").select2({
	placeholder: "Seleccione Gerencia",
	allowClear: true,
	width:'100%',
	minimumInputLength: -1,
	});
	
</script>