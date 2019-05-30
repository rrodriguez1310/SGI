<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle del contenido'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body"> 
							<div class="col-md-6">
								<div class="col-md-12">
									<label for="" class="col-md-4 control-label">Contenido:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionContenido['InduccionContenido']['titulo']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Orden:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionContenido['InduccionContenido']['peso']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Lección:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionContenido['InduccionEtapa']['titulo']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Estado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionContenido['InduccionEstado']['nombre']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Imagen de fondo:</label>
									<div class="col-md-8 " style="width: 80px !important; hight:80px !important;"><?php echo $this->Html->image('../files/induccion_contenido/image/'.$induccionContenido['InduccionContenido']['imagedir'].'/vga_'.$induccionContenido['InduccionContenido']['image']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Descripción:</label>
									<div class="col-md-8 baja mayuscula" id="texto" style="word-break:break-all;word-wrap:break-word;width: 800px;"><?php echo unserialize($induccionContenido['InduccionContenido']['descripcion']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Creado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($induccionContenido['InduccionContenido']['created']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Modificado:</label>
									<div class="col-md-8 baja mayuscula" ><?php echo h($induccionContenido['InduccionContenido']['modified']); ?></div>
								</div>
							</div>

							<!--div class="col-md-6" style="height: 240px;">
								<div  class="">
									<label for="" class="col-md-4 control-label">Imagen:</label>
									<div class="col-md-12 "><?php echo $this->Html->image('../files/induccion_contenido/image/'.$induccionContenido['InduccionContenido']['imagedir'].'/vga_'.$induccionContenido['InduccionContenido']['image']); ?></div>
								</div>
							</div-->
							
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



