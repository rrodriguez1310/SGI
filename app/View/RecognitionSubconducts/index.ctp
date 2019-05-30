<div ng-controller="recognitionSubconducts" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
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
		'angularjs/servicios/recognition/recognitionSubconducts',
		'angularjs/controladores/recognition/recognitionSubconducts',
		'angularjs/directivas/confirmacion',
	));
?>