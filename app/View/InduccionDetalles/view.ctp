<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle del archivo'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9 baja mayuscula" style="word-wrap: break-word;"><?php echo h($induccionDetalle['InduccionDetalle']['texto']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Estado:</label>
								<div class="col-md-8 baja mayuscula"><?php echo h($induccionDetalle['Estado']['nombre']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Creado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($induccionDetalle['InduccionDetalle']['created']); ?></div>
							</div>

							<div  class="col-md-12">
								<label for="" class="col-md-3 control-label">Modificado:</label>
								<div class="col-md-9 baja mayuscula"><?php echo h($induccionDetalle['InduccionDetalle']['modified']); ?></div>
							</div>

							<div class="col-md-12" style="height: 240px;">
								<div  class="">
									<label for="" class="col-md-3 control-label">Imagen:</label>
									<div class="col-md-9 "><?php echo $this->Html->image('../files/induccion_detalle/image/'.$induccionDetalle['InduccionDetalle']['imagedir'].'/vga_'.$induccionDetalle['InduccionDetalle']['image']); ?></div>
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

<!--
<pre><?php //print_r($status); ?></pre>
-->
