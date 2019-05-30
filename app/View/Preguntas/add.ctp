
<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('Pregunta', array('class' => 'form-horizontal')); ?>
		<h4><?php echo __('Registrar Pregunta'); ?></h4>
		<br>
		<div class="form-group">
			<label class="col-md-2 control-label baja">Pregunta</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('Pregunta.pregunta', array("type"=>"text","class"=>"form-control", "placeholder"=>"Ingrese pregunta", "label"=>false, "required"=>"required", 'maxlength'=>'300', "id"=>"Pregunta"));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label baja">Respuesta</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('Pregunta.respuesta', array("type"=>"text","class"=>"form-control baja", "placeholder"=>"Ingrese respuesta", "label"=>false, "required"=>"required", "id"=>"Respuesta", "empty"=>""));?>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-2 control-label baja">Prueba</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('Pregunta.prueba_id', array("class"=>"form-control baja","class"=>"form-control mayuscula", "placeholder"=>"Seleccione una prueba", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"Prueba", "empty"=>""));?>
			                                                          
			</div>
		</div>
			<div class="form-group">
			<label class="col-md-2 control-label baja">N° Pregunta</label>
			<div class="col-md-7">
				<?php echo $this->Form->input('Pregunta.numero_pregunta', array("type"=>"number","class"=>"form-control mayuscula", "placeholder"=>"Ingrese n° pregunta", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"numero_pregunta"));?>
			</div>
		</div>
		
		<br>
		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>
        	<!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a-->
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>

$(" #Prueba").select2();
$(" #Prueba").select2('data', null);
$(".mayuscula").on("change", function(){ $(this).val( $(this).val().toUpperCase())});
</script>

