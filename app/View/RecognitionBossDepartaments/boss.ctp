<div ng-controller="bossController" ng-cloak>
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
		'angularjs/servicios/recognition/recognitionBoss',
		'angularjs/controladores/recognition/recognitionBoss',
		'angularjs/directivas/confirmacion'
	));
?>