<div class="col-md-10 col-md-offset-1">
	<?php echo $this->Form->create('TransmisionSenale', array('class' => 'form-horizontal')); ?>
			<h4><?php echo __('Registrar Transmisión Señal'); ?></h4>
			<br/>
			<?php echo $this->Form->input('id'); ?>
			<div class="form-group">
				<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Nombre</label>
				<div class="col-md-8">
					<?php echo $this->Form->input('nombre', array('type'=>'text',"class"=>"form-control requerido", "placeholder"=>"Nombre Descripción", "label"=>false, "required"=>"required", 'maxlength'=>'100', "id"=>"Nombre"));?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4 control-label baja"><span class="aterisco">*</span>Medio de Transmisión</label>
				<div class="col-md-8">
					<select id="transmision_medio_transmisione_id" class="form-control" name="transmision_medio_transmisione_id">
						<?php						
						foreach ($medios as $key => $value){
							if($this->Form->data["TransmisionSenale"]["transmision_medio_transmisione_id"] == $value['id']){ ?>
								<option selected="selected" value="<?php echo $value['id']; ?>"><?php echo $value['nombre']; ?></option>
								<?php
							}else{ ?>
								<option value="<?php echo $value['id']; ?>"><?php echo $value['nombre']; ?></option><?php							
							}
						}  ?>
					</select>
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
	$('#CatalogacionRDescripcioneEditForm').submit(function () {
		if($(this).valid()){
			$("#submit").prop("disabled",true);
			$("#safe").click();
		}
	});
</script>