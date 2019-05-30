<div ng-controller="AppCtrlListaEventos" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>
		<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/produccionPartidos/produccionPartidos',
		'angularjs/servicios/produccionPartidos/produccionPartidos',
		'angularjs/directivas/confirmacion',
	));	
?>