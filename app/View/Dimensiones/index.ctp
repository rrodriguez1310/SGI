<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/dimensiones',
		'angularjs/directivas/confirmacion',
	));
?>

<div ng-controller="Dimensiones">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('toolbox_angular'); ?>
		<div>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>
</div>

<script>
	$('.tool').tooltip();
</script>