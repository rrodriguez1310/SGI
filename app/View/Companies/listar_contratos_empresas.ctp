<div ng-controller="EmpresasCtrl" ng-cloak>
    <p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-md-12" ng-show="tablaDetalle">
		<legend>Lista de documentos</legend>
        <?php echo $this->element('botonera'); ?>
        <div ui-grid="gridOptions" class="grid" ui-grid-selection ui-grid-exporter ui-grid-resize-columns ui-grid-move-columns></div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/empresas/empresas',
		'angularjs/controladores/empresas/lista_contratos',
	));
?>
