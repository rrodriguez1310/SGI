<div class="col-sm-offset-3 col-sm-8">
	<h2><?php echo __('Actualizar Categoría'); ?></h2>
</div>
<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="recognitionCategories form">
	<?php echo $this->Form->create('RecognitionCategory',array('class' => 'form-horizontal')); ?>
		<?php echo $this->Form->input('id'); ?>
		<fieldset>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label"><span class="aterisco">*</span>Nombre: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('name', array("type"=>"text", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="inputPassword3" class="col-sm-3 control-label"><span class="aterisco">*</span>Estatus: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('statu_id', array("type"=>"select", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Descripción: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('descrption', array("type"=>"textArea", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div> 
				<div class="col-sm-offset-1 col-sm-8 box-footer">
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default pull-left"><i class="fa fa-mail-reply-all"></i> Volver</a>
					<button class="btn btn-primary pull-right" type="submit"><i class="fa fa-pencil"></i> Guardar</button>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>



