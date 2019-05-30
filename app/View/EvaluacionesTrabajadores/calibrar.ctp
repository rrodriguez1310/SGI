<div ng-controller="calibradorIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="margin-t-10">Evaluación de Desempeño CDF {{anioEvaluado}}</h3>
			</div>
		</div>
		<div class="row margin-t-10">
			<div class="col-md-4">
				<div><h4><i class="fa fa-balance-scale fa-lg margin-r-10"></i>Calibrador</h4></div>
				<div class="panel panel-warning">
					<div class="panel-heading" >
						<h3 class="panel-title text-warning"><i class="fa fa-file-text-o margin-r-10"></i>Mi desempeño</h3>
					</div>
					<div class="panel panel-body">
						<div class="col-md-5 col-xs-12">
							<div class="img-circle img-fondo-100 center-block" ng-if="calibrador.foto" style="background-image:url({{calibrador.foto}})" width="100" height="100"></div>
						</div>
						<div class="col-md-7 col-xs-12 text-center">
							<div><h4 class="text-warning">{{calibrador.nombre}}</h4></div>
							<div>{{calibrador.cargo}}</div>
						</div>
						<div class="col-md-7 col-xs-12 text-center margin-t-10" ng-show="calibrador.evaluaciones_trabajadore_id">
							<a class="btn btn-primary btn-md baja" href="<?php echo Router::url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'view'));?>/{{calibrador.evaluaciones_trabajadore_id}}"><i class="fa fa-eye margin-r-10"> </i>Ver evaluación</a>	
						</div>
					</div>
				</div>
			</div>		

			<div class="col-md-8">
				<div>
					<h4>Colaboradores Pendientes</h4>
				</div>
				<div>
					<?php echo $this->element("botonera"); ?>
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:400px;"></div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<?php //echo $this->element("ficha_trabajador"); ?>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	//	'angularjs/servicios/servicios',
	));
?> 