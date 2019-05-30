<div ng-controller="controllerRequerimientos" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	
	<?php echo $this->element('botonera'); ?>

	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
</div>

<?php 
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_requerimiento_servicio/solicitudesRequerimiento',
		'angularjs/controladores/solicitudes_requerimientos_fondos/solicitudes_requerimientos',
		'angularjs/directivas/confirmacion'
	));
?>


