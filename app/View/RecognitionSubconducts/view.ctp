<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle del comportamiento'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['RecognitionSubconduct']['name']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Valor:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['Conduct']['name']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Puntaje:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['RecognitionSubconduct']['points']); ?></div>
							</div>
							
							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Estado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['Statu']['name']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Descripción:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['RecognitionSubconduct']['descrption']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Creado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['RecognitionSubconduct']['created']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Modificado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionSubconduct['RecognitionSubconduct']['modified']); ?></div>
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

