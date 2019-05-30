<div ng-controller="catalogacionRequerimientosBatchRequerimiento" ng-cloak ng-init="requerimientoId(<?php echo $this->request->pass[0]; ?>, <?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
			<h4>Batch requerimiento</h4>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="catalogacionRAsignarResponsableForm" novalidate>
					<div class="form-group" ng-class="{ 'has-error': !catalogacionRAsignarResponsableForm.ingesta_nombre.$valid }">
						<label for="ingesta_nombre" class="col-md-3 control-label baja">Nombre</label>
						<div class="col-md-9">
							<input type="text" name="ingesta_nombre" id="ingesta_nombre" class="form-control" ng-model="batch.nombre" ng-required="formulario.CatalogacionRIngesta.length==0">
						</div>	
					</div>
					<div class="form-group" ng-class="{ 'has-error': !catalogacionRAsignarResponsableForm.ingesta_reel.$valid }">
						<label for="nombre" class="col-md-3 control-label baja">Reel</label>
						<div class="col-md-9">
							<input type="text" name="ingesta_reel" id="ingesta_reel" class="form-control" ng-model="batch.reel" ng-required="formulario.CatalogacionRIngesta.length==0">
						</div>	
					</div>
					<div class="form-group" ng-class="{ 'has-error': entradaClass }">
						<label for="nombre" class="col-md-3 control-label">Entrada</label>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.horasIn" name="horasIn" id="horasIn" ng-options="hora for hora in horas" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Horas</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.minutosIn" ng-options="minuto for minuto in minutos" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Minutos</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.segundosIn" ng-options="minuto for minuto in minutos" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Segundos</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.bloquesIn" ng-options="cuadro for cuadro in cuadros" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Cuadros</option>
							</select>
						</div>	
					</div>
					<div class="form-group" ng-class="{ 'has-error': salidaClass }">
						<label for="nombre" class="col-md-3 control-label">Salida</label>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.horasOut" ng-options="hora for hora in horas" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Horas</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.minutosOut" ng-options="minuto for minuto in minutos" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Minutos</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.segundosOut" ng-options="minuto for minuto in minutos" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Segundos</option>
							</select>
						</div>
						<div class="col-md-2">
							<select class="form-control" ng-model="batch.bloquesOut" ng-options="cuadro for cuadro in cuadros" ng-required="formulario.CatalogacionRIngesta.length==0">
								<option value="">Cuadros</option>
							</select>
						</div>	
					</div>
					<div class="form-group text-center">
						<button class="btn btn-default" ng-click="agregarDetalle()" ng-disabled="batchDisabled"><i class="fa fa-plus-circle"></i> Agregar</button>
					</div>
					<br />
					<div ng-if="formulario.CatalogacionRIngesta.length!=0">
						<div class="row">
							<div class="col-md-12">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Reel</th>
											<th>Entrada</th>
											<th>Salida</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(key, valores) in formulario.CatalogacionRIngesta" ng-if="valores.estado==1">
											<td>{{ valores.nombre }}</td>
											<td>{{ valores.reel }}</td>
											<td>{{ valores.entrada }}</td>
											<td>{{ valores.salida }}</td>
											<td class="text-right"><a class="btn btn-danger btn-sm" ng-click="eliminarDetalle(key)"><i class="fa fa-trash-o"></i></a></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="formulario.CatalogacionRIngesta.length ==0 || registrando" ng-click="registrarBatchRequerimiento()"><i class="fa fa-pencil"></i> Ingresar</button>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_requerimientos", "action"=>"index"), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/servicios/catalogacion_requerimientos/catalogacion_requerimientos",
	"angularjs/servicios/catalogacion_r_responsables/catalogacion_r_responsables",
	"angularjs/servicios/users/lista_users_service",
	"angularjs/factorias/users/users",
	"angularjs/factorias/catalogacion_r_responsables/catalogacion_r_responsables",
	"angularjs/factorias/catalogacion_requerimientos/catalogacion_requerimientos",
	"angularjs/controladores/catalogacion_requerimientos/catalogacion_requerimientos",
	"select2.min"
	));
?>