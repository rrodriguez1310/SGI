<div class="col-md-7 col-md-offset-3">
	<?php echo $this->Form->create('ListaCorreosTipo', array('class'=>'form-horizontal')); ?>
		<fieldset>
			<h4 class="col-md-offset-2"><?php echo __('Registrar tipo para lista de correos'); ?></h4>
			<div class="form-group">
				<label class="col-md-2 control-label baja">Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese Nombre", "label"=>false, "required"=>"required"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label baja">Descripción</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('descripcion', array("class"=>"form-control mayuscula", "placeholder"=>"Ingrese Descripción", "label"=>false, "required"=>"required"));?>
				</div>
			</div>				
		</fieldset>
		<br/><br/>
		<button class="btn btn-primary btn-lg col-md-offset-2"><i class="fa fa-pencil-square-o"></i> Registrar</button>
		<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
		
	<?php echo $this->Form->end(); ?>
</div>