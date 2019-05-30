
<div>
	<div class="row">
		<div class="col-sm-12 text-center">
			<h2 class="margin-t-10">Programa de Inducción Corporativa CDF.</h2> <br><br>
		</div>
	</div>

	<div class="col-md-12">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-sm-12" style="color: black !important; font-size:16px; !important;">
					<p class="text-justify">
						<strong>
							A través de este curso podrás comprender nuestra organización y su cadena de valor, lo cual facilitará tu integración a nuestro canal a través del aprendizaje. <br>
						</strong>
					</p>
					<p class="text-justify">
						<strong>
							De este modo, conocerás la historia e hitos más importantes de CDF; el modelo de negocio, la realización de nuestros servicios, así como las respectivas operaciones y los principales clientes.
							Por otro lado, entenderás el marco valórico y la estrategia de la compañía, así como las políticas de gestión de personas, entre otras temáticas. <br>
						</strong>
					</p>
					<p>
						<strong>
						¡Mucho éxito! <br>
						</strong>
					</p>

					
				</div>
				<p>&nbsp;</p><br>
			</div>
		</div>

		<div class="text-center">
			<div>
				<?php 
					foreach ($accesoPaginas as $pagina) :
						if($pagina["controlador"] == 'induccionPantallas' && $pagina["accion"] == 'index' ) :  ?>
							<a class="btn btn-primary btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'induccionPantallas', 'action' => 'index'));?>" style="width:225px; margin-left: 10px;">
								<i class="fa fa-play-circle  fa-4x"></i><br>
								Comenzar curso.
							</a>
                        <?php 	endif;   
					endforeach;	?>
			</div>
			<p>&nbsp;</p>
		</div>

		<div class="text-center">
			<?php echo $this->Html->image("cuadroValores.png", array('fullBase' => true, "style"=>"width:80%; height:50%; box-shadow: 5px 7px 10px #666;")); ?>
		</div>
	</div>
</div>
