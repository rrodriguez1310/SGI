<div ng-controller="ListaTrabajadores" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-md-12">
				<h3>Lista de Trabajadores</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element("botonera"); ?>
				<div>
					<br>	
					<div ui-grid="gridOptions" ui-grid-edit ui-grid-cellnav ui-grid-exporter class="grid"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/trabajadores',
		'angularjs/controladores/trabajadores/trabajadores',
	));
?> 