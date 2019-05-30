<div ng-controller="codigosPresupuestosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<id class="mensaje"></id>
		<div class="row">
			<div class="col-md-12">
				<h3>Lista de Codigos Presupuestarios</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element("botonera"); ?>
				<div>
					<br>	
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/directivas/confirmacion",
		"angularjs/servicios/codigos_presupuestos/codigos_presupuestos",
		"angularjs/controladores/codigos_presupuestos/codigos_presupuestos"
		)
	);
?>
