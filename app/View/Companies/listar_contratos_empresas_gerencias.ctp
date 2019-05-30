<div ng-controller="EmpresasCtrl">
	<div class="col-md-12">
		<legend>Lista de documentos</legend>
		<p ng-bind-html="cargador" ng-show="loader"></p>
		<?php echo $this->element('botonera'); ?>
		<div ng-show="tablaDetalle">
			<div ui-grid="gridOptions" class="grid" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ui-grid-move-columns></div>
		</div>
		
	</div>
</div>
<?php
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/empresas/empresas',
		'angularjs/controladores/empresas/lista_contratos_gerencia',
	));
?>