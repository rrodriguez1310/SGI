<div ng-controller="detallesController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="text-center"><h2>Seleccione una imagen</h2></div>
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
		'angularjs/servicios/induccion/detallesService',
		'angularjs/controladores/induccion/detallesController',
		'angularjs/directivas/confirmacion',
	));
?>