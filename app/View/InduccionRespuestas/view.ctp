<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle de la respuesta'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div class="col-md-12">
								<div  class="">
									<label for="" class="col-md-4 control-label">Pregunta:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionRespuesta['Pregunta']['pregunta']); ?></div>
								</div>
								<div  class="">
									<label for="" class="col-md-4 control-label">Respuesta:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionRespuesta['InduccionRespuesta']['respuesta']); ?></div>
								</div>

								<div  class="">
									<label for="" class="col-md-4 control-label">Estado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionRespuesta['Estado']['nombre']); ?></div>
								</div>

								<div  class="">
									<label for="" class="col-md-4 control-label">Creado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionRespuesta['InduccionRespuesta']['created']); ?></div>
								</div>

								<div  class="">
									<label for="" class="col-md-4 control-label">Modificado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionRespuesta['InduccionRespuesta']['modified']); ?></div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
				<div class="panel-footer">
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default"><i class="fa fa-mail-reply-all"></i> Volver</a>
				</div> 
			</div>
		</div>
	</div>
</form>
