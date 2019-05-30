<div ng-controller="ListaPaginasIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-xs-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-resize-columns class="grid"></div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/filtros/filtros',
		'angularjs/servicios/lista_paginas_service',
		'angularjs/servicios/lista_paginas_roles_service',
		'angularjs/servicios/paginas_roles/paginas_roles',
		'angularjs/factorias/paginas/paginas',
		'angularjs/controladores/lista_paginas',
		'angularjs/directivas/confirmacion',
	));
?>
<script>
	$('.tool').tooltip();
</script>