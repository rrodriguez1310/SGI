<div ng-controller="evaluacionesIndex" ng-init="inicio=true" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12 text-center">
				<h3 class="margin-t-10">Evaluación de Desempeño CDF {{anioEvaluado}}</h3>
			</div>
		</div>

		<div class="col-md-12">
			<div><h4>Gestión de Desempeño CDF</h4></div>
			<div>
				Es un proceso de gestión y evaluación sistemática y continua del desempeño integral de cada colaborador, incluyendo aportes en términos de productividad así como competencias vinculadas a las características y responsabilidades de su cargo.
			</div>
			<p>&nbsp;</p>
			<div><h4>Bienvenidos/as al Sistema de Gestión de Desempeño CDF.</h4></div>
			<div>
				En esta plataforma podrás desarrollar cada una de las etapas que contempla la gestión de desempeño en nuestra empresa, ya sea evaluar, calibrar, agendar diálogo y conocer tu desempeño.
			</div>
			<p>&nbsp;</p><br>
			<div class="text-center">
				<?php 
					foreach ($accesoPaginas as $pagina) :
						if($pagina["accion"] == 'evaluar') :  ?>
					<a class="btn btn-primary btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'evaluar'));?>" style="width:130px">
						<i class="fa fa-check fa-4x"></i><br>
				    	Evaluación
					</a>
				<?php 	endif; 
						if($pagina["accion"] == 'calibrar') :  ?>
					<a class="btn btn-warning btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'calibrar'));?>" style="width:130px">
						<i class="fa fa-balance-scale fa-4x"></i><br>
						Calibración
					</a>
				<?php 	endif; 
						if($pagina["accion"] == 'desempeno') :  ?>
					<a class="btn btn-success btn-lg col-md-offset-1 col-xs-offset-0" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'desempeno'));?>" style="width:130px">
						<i class="fa fa-line-chart fa-4x"></i><br>
						Desempeño
					</a>
				<?php 	endif; 
					endforeach;	?>
			</div>
			<p>&nbsp;</p>
		</div>

	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	));
?> 