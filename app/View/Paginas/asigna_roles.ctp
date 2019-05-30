<div ng-controller="ListaPaginasAsignaPaginas" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
		<div ng-show="tablaDetalle">
			<div class="row">
				<div class="col-md-12 text-center">
					<h3>Rol Seleccionado : <strong><?php echo __($rolSeleccionado); ?></strong></h3>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->element('botonera'); ?>
					<?php //echo $this->element('toolbox_angular'); ?>
					<div class="col-xs-12">
						<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-resize-columns ui-grid-move-columns ui-grid-pinning class="grid"></div>

					</div>
				</div>
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
		'angularjs/directivas/paginas_roles',
		'angularjs/directivas/botones_extras/boton_asociar_pagina_rol',
	));
?>
<script>
	$('.tool').tooltip();
</script>