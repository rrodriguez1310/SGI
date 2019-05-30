<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle de la Categoría'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionCategory['RecognitionCategory']['name']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Estatus:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($status[$recognitionCategory['RecognitionCategory']['statu_id']]); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Descripción:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionCategory['RecognitionCategory']['descrption']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Creado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionCategory['RecognitionCategory']['created']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Modificado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($recognitionCategory['RecognitionCategory']['modified']); ?></div>
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

<!--
<pre><?php //print_r($status); ?></pre>
-->
