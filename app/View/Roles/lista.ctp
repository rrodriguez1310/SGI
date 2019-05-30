<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/lista_roles_service',
		'angularjs/servicios/buscador_grid_service',
		'angularjs/controladores/lista_roles',
		//'angularjs/directivas/buscador_uigrid'
	));
?>

<div ng-controller="ComprasRoles">
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