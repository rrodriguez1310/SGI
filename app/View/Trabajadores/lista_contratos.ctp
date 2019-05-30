<div ng-controller="trabajadoresListaContratos" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Listado Contratos Trabajadores</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns ui-grid-auto-resize></div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/servicios/documentos/documentos",
	"angularjs/controladores/trabajadores"
));
?>