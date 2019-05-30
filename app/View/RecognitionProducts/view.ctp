<form class="form-horizontal">
	<div class="container">
		<div class="col-md-10 col-md-offset-1 toppad" >
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-12">
							<h3 class="panel-title"><?php echo __('Detalle del producto'); ?></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">	
					<div class="col-md-12">
						<div class="panel-body">
							<div class="col-md-6">
								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Nombre:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['name']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Valor:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['points']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Cantidad:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['quantity']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Categoría:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['Category']['name']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Estado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['Statu']['name']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Descripción:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['descrption']); ?></div>
								</div>

								<div  class="">
									<label for="" class="col-md-4 control-label">Creado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['created']); ?></div>
								</div>

								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Modificado:</label>
									<div class="col-md-8 baja mayuscula"><?php echo h($recognitionProduct['RecognitionProduct']['modified']); ?></div>
								</div>
							</div>

							<div class="col-md-6" style="height: 240px;">
								<div  class="col-md-12">
									<label for="" class="col-md-4 control-label">Imagen:</label>
									<div class="col-md-12 "><?php echo $this->Html->image('../files/recognition_product/image/'.$recognitionProduct['RecognitionProduct']['imagedir'].'/vga_'.$recognitionProduct['RecognitionProduct']['image']); ?></div>
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

