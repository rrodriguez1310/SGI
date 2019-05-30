<div class="col-xs-12 col-sm-12 col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
    		<h3 class="panel-title">Produccion de partidos :: responsables cdf</h3>
 			</div>
 			<div class="panel-body">
    		<?php echo $this->Form->create('ProduccionPartido'); ?>
    			<div class="row">
    				<div class="col-xs-12 col-sm-6 col-md-6">
    					<label>Ingrese productor</label>
    					<div class="form-group">
    						<?php echo $this->Form->input('productor', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Productor", "options"=>$productores, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
    					</div>
    				</div>

    				<div class="col-xs-12 col-sm-6 col-md-6">
    					<label>Ingrese Asistente de producción</label>
    					<div class="form-group">
    						<?php echo $this->Form->input('asist_produccion', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Asistente de producción", "options"=>$asistenteProduccion, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
    					</div>
    				</div>

    				<div class="col-xs-12 col-sm-6 col-md-6">
    					<label>Ingrese Relator</label>
		    			<div class="form-group">
		    				<?php echo $this->Form->input('relator', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Relator", "options"=>$relator, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
		    			</div>
		    		</div>

		    		<div class="col-xs-12 col-sm-6 col-md-6">
		    			<label>Ingrese Comentarista</label>
		    			<div class="form-group">
		    				<?php echo $this->Form->input('comentarista', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Comentarista", "options"=>$comentarista, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
		    			</div>
		    		</div>

		    		<div class="col-xs-12 col-sm-6 col-md-6">
		    			<label>Ingrese Periodista cancha</label>
		    			<div class="form-group">
		    				<?php echo $this->Form->input('periodista_cancha', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Periodista en cancha", "options"=>$periodista, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
		    			</div>
		    		</div>

		    		<div class="col-xs-12 col-sm-6 col-md-6">
		    			<label>Ingrese Operador Track-vision</label>
		    			<div class="form-group">
		    				<?php echo $this->Form->input('operador_trackvision', array("label"=>false, "class"=>"form-control ", "placeholder"=>"Operador Trackvision", "options"=>$operadorTrackVision, "empty"=>"", 'multiple'=> 'true', 'required'=> 'true')); ?>
		    			</div>
		    		</div>
    			</div>
    			<button type="submit" class="btn  btn-primary "><i class="fa fa-plus"></i>  Guardar</button>
    		
    		<?php echo $this->Form->end(); ?>
    	</div>
	</div>
</div>