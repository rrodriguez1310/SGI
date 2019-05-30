<div class="col-sm-offset-3 col-sm-8">
	<h2><?php echo __('Actualizar Archivo'); ?></h2>
</div>
<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="induccionDetalles form">
	<?php echo $this->Form->create('InduccionDetalle',array('type' => 'file', 'class' => 'form-horizontal')); ?>
		<fieldset>

		<?php echo $this->Form->input('id'); ?>

		<div class="form-group">
				<label for="" class="col-sm-3 control-label">Nombre: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('texto', array("type"=>"textArea", "required", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Imagen: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('image', array('type' => 'file', "class"=>"form-control", "accept"=>".jpg, .jpeg, .png", "label"=>false ,'id' => 'foto',));?>
				</div>
			</div>
			
			<?php echo $this->Form->input('imagedir', array('type' => 'hidden'));?>

			<!-- div class="form-group">
				<label for="" class="col-sm-3 control-label">Peso: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('peso', array("type"=>"number", "min"=>"1", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Contenido: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('contenido_id', array("type"=>"select", "class"=>"form-control", "label"=>false, 'empty' => 'Seleccione...'));?>
				</div>
			</div -->

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Estado: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('estado_id', array("type"=>"select", "class"=>"form-control", "label"=>false, 'empty' => 'Seleccione...'));?>
				</div>
			</div>

			<div> 
				<div class="col-sm-offset-1 col-sm-8 box-footer">
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default pull-left"><i class="fa fa-mail-reply-all"></i> Volver</a>
					<button class="btn btn-primary pull-right" type="submit"><i class="fa fa-pencil"></i> Actualizar</button>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#foto').css({'color':'transparent'});

		$('.file').click(function() {
			$('#foto').css({'color':'black'});
		});
	});
</script>


