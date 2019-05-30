<div ng-controller="bossDepartaments" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>

	<div class="text-center">
		<h2>Seleccione un jefe de area</h2>
	</div>
	
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
		'angularjs/servicios/recognition/recognitionBossDepartaments',
		'angularjs/controladores/recognition/recognitionBossDepartaments',
		'angularjs/directivas/confirmacion'
	));
?>