<div ng-controller="calibrarIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="margin-t-10">Objetivos Clave de Desempeño {{anioAEvaluar}}</h3>
			</div>
		</div>

		<div class="row margin-t-10">
			<div class="col-md-2">			
				<div class="panel panel-warning">
					<div class="panel-heading">
						<h3 class="panel-title text-warning"> <i class="fa fa-balance-scale fa-lg margin-r-10"></i> Calibrador</h3>
					</div>
					<div class="panel panel-body">
						<div class="col-md-12 col-xs-12">
							<div class="img-circle img-fondo-100 center-block" ng-if="calibrador.foto" style="background-image:url({{calibrador.foto}})" width="100" height="100"></div>  
						</div>
						<div class="col-md-12 col-xs-12 text-center">
							<div class="text-success"><h4>{{calibrador.nombre}}</h4></div>
							<div>{{calibrador.cargo}}</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-10">
				<div>
					<h4>Colaboradores Pendientes</h4>
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