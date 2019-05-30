<div ng-controller="leccionesController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="text-center"><h2>Seleccione una lección</h2></div>
	<?php echo $this->element('botonera'); ?>

	<div>
		<br>
		<div ng-show="tablaDetalle">
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>

</div>
	
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/induccion/leccionesService',
		'angularjs/controladores/induccion/leccionesController',
		'angularjs/directivas/confirmacion',
	));
?>