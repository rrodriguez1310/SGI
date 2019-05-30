<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle jefe de area'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Jefe:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($salida[0]['Trabajadore']['nombre']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Puntos asignados:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['points_add']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Estatus:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionBossDepartament['Statu']['name']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Descripción:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['descrption']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Creado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['created']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Modificado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionBossDepartament['RecognitionBossDepartament']['modified']); ?></div>
							</div>

						</div>
					</div>
				</div>
				<div class="panel-footer">
				<a href="<?php echo $this->Html->url(array("action"=>"boss"))?>" class="volver btn btn-default"><i class="fa fa-mail-reply-all"></i> Volver</a>
				</div> 
			</div>
		</div>
	</div>
</form>