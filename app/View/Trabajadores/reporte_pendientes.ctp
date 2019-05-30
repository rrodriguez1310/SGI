<div ng-controller="trabajadoresReportePendientes">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="reporteShow">
		<div class="row">
			<div class="col-md-12">
				<h3>Reporte Pendientes</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div trabajadores-pendientes-directive>
				</div>
				<!--<div ng-toolbox-trabajadores>
					
				</div ng-toolbox-trabajadores-->
				<div>
					<br>	
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ng-model="grid" class="grid"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/directivas/trabajadores/trabajadores",
		"angularjs/directivas/modal/modal",
		"angularjs/filtros/filtros",
		"angularjs/servicios/trabajadores",
		"angularjs/servicios/tipos_documentos/tipos_documentos",
		"angularjs/factorias/trabajadores",
		"angularjs/controladores/trabajadores",
		)); 
?>