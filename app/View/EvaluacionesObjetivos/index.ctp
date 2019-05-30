<div ng-controller="objetivosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="margin-t-10">Objetivos Clave de Desempeño {{anioAEvaluar}}</h3>
			</div>
		</div>

		<div class="row margin-t-10">
			<div class="col-md-2">
				<!--div><h4><i class="fa fa-check fa-lg margin-r-10"></i>Evaluador</h4></div-->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title" style="color: #fff !important"> <i class="fa fa-check margin-r-10"></i> Evaluador</h3>
					</div>
					<div class="panel panel-body">
						<div class="col-md-12 col-xs-12">
							<div class="img-circle img-fondo-100 center-block" ng-if="evaluador.foto" style="background-image:url({{evaluador.foto}})" width="100" height="100"></div>
						</div>
						<div class="col-md-12 col-xs-12 text-center">
							<div class="text-success"><h4>{{evaluador.nombre}}</h4></div>
							<div>{{evaluador.cargo}}</div>
						</div>
						<!--div class="col-md-7 col-xs-12 text-center margin-t-10" ng-show="evaluador.evaluaciones_trabajadore_id">
							<a class="btn btn-primary btn-md baja" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'view'));?>/{{evaluador.evaluaciones_trabajadore_id}}"><i class="fa fa-eye margin-r-10"> </i>Ver evaluación</a>
						</div-->
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<div>
					<h4>Equipo de colaboradores</h4>
				</div>
				<div>
					<?php echo $this->element("botonera"); ?>
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:400px;"></div>					
				</div>
			</div>	
		</div>	
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/evaluaciones_objetivos/evaluaciones_objetivos',
		'angularjs/servicios/evaluaciones_objetivos/evaluaciones_objetivos',
	));
?> 