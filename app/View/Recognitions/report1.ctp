<div ng-controller="recognitionReport" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div style="text-align:center;">
		<h2>Consolidado de reconocimientos.</h2>
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
		'angularjs/servicios/recognition/recognitionReport1',
		'angularjs/controladores/recognition/recognitionReport1'
	));
?>