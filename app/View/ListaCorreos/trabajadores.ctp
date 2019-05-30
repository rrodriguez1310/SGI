<id class="mensaje"></id>
<div ng-controller="listaCorreosTrabajadores" ng-init="idlistaCorreo = <?php echo $this->passedArgs[0] ?>" ng-cloak>
	<div class="row">
		<div class="col-md-12 text-center">
			<h4>Lista de Correos {{ nombreListaCorreo | capitalize }}</h4>
		</div>
	</div>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
					</div>
					<div class="panel-body" ng-init="isDisabled = true">
						<ul class="list-inline menu_superior_angular">
							<li class="addbtn">
								<a ng-show="boton" class="btn-sm btn btn-primary tool" data-placement="bottom" data-toggle="tooltip" ng-click="agregarCorreo(id)" data-original-title="Insertar"><i class="fa fa-floppy-o"></i></a>
							</li>
						</ul>
						<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
					</div>
				</div>
				<div>
					<br>	
					<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ng-model="grid" style="height: 250px"></div>
				</div>
			</div>
		</div>
	</div>
	<div ng-show="seleccionadosTabla">
		<div class="row">
			<div class="col-md-12">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th colspan="4" class="text-center">Listado de Correos Seleccionados</th>
						</tr>
						<tr>
							<th>Nombre</th>
							<th>Correo</th>
							<th>Cargo</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="seleccionado in seleccionados">
							<td>{{ seleccionado.nombre }}</td>
							<td>{{ seleccionado.email }}</td>
							<td>{{ seleccionado.cargo }}</td>
							<td><a class="btn-sm btn btn-danger tool" ng-click="eliminarCorreoAsociado(seleccionado.id, seleccionado.nombre)" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar"><i class="fa fa-trash-o"></i></a></td>
						</tr>
					</tbody>
				</table>	
			</div>
		</div>
	</div>
	<div class="col-md-12 text-center">
		<a class="volver btn btn-default btn-lg" href="{{ locationListaCorreos }}">
			<i class="fa fa-mail-reply-all"></i>
			Volver
		</a>
	</div>
</div>
<?php 
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/servicios/lista_correos',
	'angularjs/servicios/trabajadores',
	'angularjs/factorias/lista_correos',
	'angularjs/factorias/trabajadores',
	'angularjs/controladores/lista_correos',
	'angularjs/directivas/confirmacion.js',
	'angularjs/angular-locale_es-cl',
	'angularjs/filtros/filtros',
	)
);
?>