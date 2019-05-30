<div ng-controller="cargosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-md-12">
				<h3>Lista de Cargos</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element("botonera"); ?>
				<!--<div ng-toolbox-trabajadores>
					
				</div ng-toolbox-trabajadores-->
				<div>
					<br>	
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ng-model="grid" class="grid"></div>
				</div>
			</div>
		</div>
	</div>
	<!--modal visible="showModal">
		<form class="form-horizontal" name="formularioCambioEstado" novalidate>
			<div class="form-group" ng-class="{ 'has-error': !formularioCambioEstado.Nueva_fecha_ingreso.$valid }">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<td class="text-center">N°</td>
						<td>Nombre</td>
						<td class="text-center">Estado</td>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="cargoTrabajador in cargoTrabajadoresList">
						<td class="text-center">{{ $index+1 }}</td>
						<td><a ng-href="{{ host }}/trabajadores/edit/{{ cargoTrabajador.id }}">{{ cargoTrabajador.nombre | capitalize }}</a></td>
						<td class="text-center">{{ cargoTrabajador.estado | capitalize }}</td>	
					</tr>
				</tbody>
			</table>
			</div>
		</form>
		<div class="modal-footer">
	        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar</button>
	    </div>
	</modal-->
</div>
<script type="text/javascript">
</script>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/directivas/confirmacion",
		'angularjs/directivas/modal/modal',
		'angularjs/filtros/filtros',
		"angularjs/controladores/cargos/cargos",
		"angularjs/servicios/cargos/cargos",
		)); 
?>