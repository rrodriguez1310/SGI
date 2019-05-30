<style>input{margin-top: 0px}</style>
<div ng-controller="evaluacionesConsolidadoIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h4><i class="fa fa-pie-chart fa-lg margin-r-10"></i>Consolidado Evaluación de Desempeño CDF {{anioEvaluado}}</h4>
			</div>
		</div>
		<br>
		<div class="row">
		<form class="form-horizontal" name="fecha" novalidate>
			<div class="col-sm-12 text-center">
				<label class="control-label text-right col-md-5 col-sm-12" >Año evaluación</label>
				<div class="col-md-7 col-sm-12">
					<ui-select ng-model="list.anioEvaluacion" name="AnioEvaluacion" style="width:220px">
						<ui-select-match placeholder=" -- Seleccione -- ">
							 <span>{{$select.selected.anio_evaluado}}</span>
						</ui-select-match>
						<ui-select-choices repeat="evaluacion.anio_evaluado as evaluacion in evaluacionesAnios | filter: $select.search">
							<div ng-bind-html="evaluacion.anio_evaluado | highlight: $select.search"></div>
						</ui-select-choices>
					</ui-select>
				</div>
			</div>
		</form>
		</div>
		<br>
		<div class="row">
			<div class="col-md-12">
				<div ui-i18n="{{lang}}">
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
		'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
		'angularjs/servicios/evaluaciones_trabajadores/evaluaciones',
	));
?> 
