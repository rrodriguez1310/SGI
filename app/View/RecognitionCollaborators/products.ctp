<div ng-controller="collaboratorProductsController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>

	<div style="text-align:center;">
		<h2>Seleccione el reconocimiento  que desea canjear</h2></br>
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
		'angularjs/servicios/recognition/collaboratorProducts',
		'angularjs/controladores/recognition/collaboratorProducts',
		'angularjs/directivas/confirmacion',

	));
?>

<script>

</script>
















