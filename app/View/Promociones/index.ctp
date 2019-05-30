<div ng-controller="indexPromocionesCtrl" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-if="contenido">
		<div class="row">
			<div class="col-md-12">
				<h3>Promociones</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element("botonera"); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid"></div>
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/directivas/confirmacion",
		"angularjs/servicios/promociones/promociones",
		"angularjs/factorias/factoria",
		"angularjs/controladores/promociones/promociones",
	));
?>
