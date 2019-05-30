<div ng-controller="catalogacionPartidosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-xs-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/catalogacion_partidos/catalogacion_partidos",
		'angularjs/controladores/catalogacion_partidos/catalogacion_partidos',
	));
?>