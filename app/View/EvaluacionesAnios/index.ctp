<div ng-controller="ListaEvaluacionesAnios" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>
		<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/evaluaciones_trabajadores/evaluaciones_anios',
		'angularjs/servicios/evaluaciones_trabajadores/evaluaciones_anios',
		'angularjs/directivas/confirmacion',
	));	
?>