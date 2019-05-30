<div class="col-md-7 col-md-offset-3">
	<?php echo $this->Form->create('CargosFamilia', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<h4 class="col-md-offset-3"><?php echo __('Registrar Familias de Cargos'); ?></h4>
			<div class="form-group">
				<label class="col-md-2 control-label baja" for="CargosFamiliaNombre">Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese nombre", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
		</fieldset>
		<br/>
		<button class="btn btn-primary btn-lg col-md-offset-3"><i class="fa fa-pencil"></i> Registrar</button>
		<a id="volver" href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
	<?php echo $this->Form->end(); ?>
</div>
