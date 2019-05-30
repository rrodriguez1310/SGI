<div class="col-md-7 col-md-offset-3">
	<?php echo $this->Form->create('RatingMinuto', array('type' => 'file', 'class'=>'form-horizontal')); ?>
	<!--<form class="form-horizontal" role="form">-->
		<div class="form-group">
			<div class="col-md-3">
				<label for="uploadMinutos" class="control-label baja">Seleccione archivo</label>	
			</div>
			<div class="col-md-9">
				<input type="file" id="uploadMinutos" name="uploadMinutos">
			</div>	
		</div>
		<div class="form-group">
			<div class="col-md-12">
				<button class="col-md-12 btn btn-primary btn-lg"><i class="fa fa-upload"></i> Importar</button>
			</div>
		</div>
	</form>
</div>