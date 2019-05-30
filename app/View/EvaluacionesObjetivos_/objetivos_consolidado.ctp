<div ng-controller="objetivosConsolidadoIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h4><i class="fa fa-pie-chart fa-lg margin-r-10"></i>Consolidado Objetivos Clave de Desempeño {{anioActual}}</h4>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<div ui-i18n="{{lang}}">
					<?php echo $this->element("botonera"); ?>
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid"></div>
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
