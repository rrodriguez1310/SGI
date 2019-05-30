<div ng-controller="reportsController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div style="text-align:center;">
		<h2>Consolidado de productos canjeados.</h2>
	</div>


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
		'angularjs/servicios/recognition/recognitionReports',
		'angularjs/controladores/recognition/recognitionReports'
	));
?>