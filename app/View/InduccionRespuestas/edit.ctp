<div class="col-sm-offset-3 col-sm-8">
	<h2><?php echo __('Actualizar Respuesta'); ?></h2>
</div>
<div class="col-md-12 col-md-offset-1">
	<br/>
	<div class="induccionRespuestas form">
	<?php echo $this->Form->create('InduccionRespuesta',array('class' => 'form-horizontal')); ?>
		<fieldset>
		
			<?php echo $this->Form->input('id'); ?>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Pregunta: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('induccion_pregunta_id', array(
							"type"=>"select", 
							"class"=>"form-control", 
							"label"=>false, 
							'empty' => 'Seleccione...',
							'options'=>$preguntas
						));
					?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Respuesta: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('respuesta', array("type"=>"text", "class"=>"form-control", "label"=>false));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Resp. Correcta: </label>
				<div class="col-sm-5">
					<?php echo $this->Form->checkbox('verdad', array( 'value' => '1','default' => '0',));?>
				</div>
			</div>

			<div class="form-group">
				<label for="" class="col-sm-3 control-label">Estado: <span class="aterisco">*</span></label>
				<div class="col-sm-5">
					<?php echo $this->Form->input('induccion_estado_id', array(
						"type"=>"select", 
						"class"=>"form-control", 
						"label"=>false, 
						'empty' => 'Seleccione...',
						'options'=>$estados
					));?>
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
