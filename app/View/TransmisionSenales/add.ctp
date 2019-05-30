<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('TransmisionSenale', array('class' => 'form-horizontal')); ?>
			<h4><?php echo __('Registrar Transmisión Señal'); ?></h4>
			<br/>
			<div class="form-group">
				<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array('type'=>'text',"class"=>"form-control", "placeholder"=>"Nombre Señal", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"Nombre"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Medio de Transmisión</label>
				<div class="col-md-8">
					<select id="transmision_medio_transmisione_id" class="form-control" name="transmision_medio_transmisione_id">
						<?php
						foreach ($medios as $key => $value){?>
							<option value="<?php echo $value['id']; ?>"><?php echo $value['nombre']; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php echo $this->Form->hidden('tipo', array("default"=>1));?>
		<br>
		<div class="col-md-offset-2">
			<button type="submit" id="submit" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i>  Guardar</button> 
        	<button type="submit" id="safe" class="hide">enviar</button>        	
		</div>
	<?php echo $this->Form->end(); ?>
</div>
<script>
	$('#TransmisionSenaleAddForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
			$("#safe").click();
		}
	});
</script>