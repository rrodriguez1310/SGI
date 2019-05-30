
<div class="col-md-10 col-md-offset-1">
<?php echo $this->Form->create('ProduccionMcrProgramas', array('class' => 'form-horizontal')); ?>
	
		<h3><?php echo __('Registrar Programa'); ?></h3>
	
	<div class="form-group">
			<label class="col-md-2 control-label baja">Nombre</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('ProduccionMcrPrograma.nombre', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese nombre", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"nombre"));?>
			</div>
		</div>
			<div class="form-group">
			<label class="col-md-2 control-label baja">Tipo</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('ProduccionMcrPrograma.tipo', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese tipo", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"tipo"));?>
			</div>
		</div>

<br>
		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a-->
		</div>
</div>

