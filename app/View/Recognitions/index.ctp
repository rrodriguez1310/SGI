
	<div>
		<div class="row">
			<div class="col-sm-12 text-center">
				<h2 class="margin-t-10">Bienvenido/a al Programa de Reconocimiento CDF.</h2>
			</div>
		</div>

		<div class="col-md-12">
			<div class="container-fluid">
				<div class="row">
					
					<div class="col-sm-12" style="color: black !important; font-size:16px !important;">
						<strong>Esta iniciativa busca promover prácticas de reconocimiento al interior de la organización que impacten positivamente la experiencia laboral y la motivación de los colaboradores y las colaboradoras.</strong>
						
					</div>
					<p>&nbsp;</p><br>
				</div>
			</div>

			<div class="text-center">
					
					<?php 
					
						foreach ($accesoPaginas as $pagina) :
							if($pagina["controlador"] == 'recognitionBossDepartaments' && $pagina["accion"] == 'collaborator' ) :  ?>
								<a class="btn btn-primary btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'recognitionBossDepartaments', 'action' => 'collaborator'));?>" style="width:225px; margin-left: 10px;">
									<i class="fa fa-thumbs-up  fa-4x"></i><br>
									Realizar Reconocimiento
								</a>
								<?php 	endif; 
							if($pagina["controlador"] == 'recognitionCollaborators' && $pagina["accion"] == 'collaborator' ) :  ?>
								<a class="btn btn-success btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'recognitionCollaborators', 'action' => 'collaborator'));?>" style="width:220px;">
									<i class="fa fa-futbol-o fa-4x"></i><br>
									Mis Reconocimientos
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
