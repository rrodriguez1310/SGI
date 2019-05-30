<div class="col-md-7 col-md-offset-3">
	<?php echo $this->Form->create('DimensionesProyecto', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<h4 class="col-md-offset-2"><?php echo __('Edición de Dimesiones Proyectos'); ?></h4>
			<?php echo $this->Form->input('id');?>
			<div class="form-group">
				<label class="col-md-2 control-label baja">Codigo</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('codigo', array("type"=>"text", "class"=>"form-control", "placeholder"=>"Ingrese codigo", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label baja">Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array("class"=>"form-control", "placeholder"=>"Ingrese nombre", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
		</fieldset>
		<br/><br/>
		<button class="btn btn-primary btn-lg col-md-offset-3"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
		<a href="<?php echo $this->Html->url(array("controller"=>"dimensiones_proyectos", "action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
	<?php echo $this->Form->end(); ?>
</div>