<div class="col-sm-offset-3 col-sm-8">
	<h2><?php echo __('Registrar Categoría'); ?></h2>
</div>
<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="recognitionCategories form">
	<?php echo $this->Form->create('RecognitionCategory',array('class' => 'form-horizontal')); ?>
		<fieldset>
			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Nombre: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('name', array("type"=>"text", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Estado: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('statu_id', array("type"=>"select", "class"=>"form-control", "label"=>false, 'empty' => 'Seleccione...'));?>
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
					<button class="btn btn-primary pull-right" type="submit"><i class="fa fa-pencil"></i> Registrar</button>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>

<!--
<pre><?php //print_r($status); ?></pre>
-->

