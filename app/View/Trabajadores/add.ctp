<div ng-controller="trabajadoresAdd">
	<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Ingresar Trabajador</h3>
			</div>
			<div class="panel-body">
				<div class="row">
					<div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php  echo $this->webroot.'files'. DS .'trabajadores'. DS ."photo.png"?>" class="img-circle"> </div>
					<div class=" col-md-9 col-lg-9 ">
						<form class="form-horizontal" name="trabajadoresAdd" novalidate>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Rut.$valid }">
								<label class="col-md-4 control-label baja" for="TrabajadoreRut">Rut</label>
								<div class="col-md-8">				           		
									<input ng-rut rut-format="live" type="text" name="Rut" id="TrabajadoreRut" class="form-control" placeholder="Ingrese rut" maxlength="12" ng-model="formulario.Trabajadore.rut" ng-blur="validaRutCompras()" required>
								</div>
							</div>    			      	
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Nombre.$valid }">
								<label class="col-md-4 control-label baja">Nombres</label>
								<div class="col-md-8">
									<input type="text" name="Nombre" class="form-control" placeholder="Ingrese nombre" ng-model="formulario.Trabajadore.nombre" required capitalize-directive>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Apellido_Paterno.$valid }">
								<label class="col-md-4 control-label baja">Apellido Paterno</label>
								<div class="col-md-8">
									<input type="text" name="Apellido_Paterno" class="form-control" placeholder="Ingrese apellido paterno" ng-model="formulario.Trabajadore.apellido_paterno" required capitalize-directive>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Apellido_Materno.$valid }">
								<label class="col-md-4 control-label baja">Apellido Materno</label>
								<div class="col-md-8">
									<input type="text" name="Apellido_Materno" class="form-control" placeholder="Ingrese apellido materno" ng-model="formulario.Trabajadore.apellido_materno" required capitalize-directive>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Fecha_Nacimiento.$valid }">
								<label class="col-md-4 control-label baja">Fecha Nacimiento</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Nacimiento" class="form-control datepicker readonly-pointer-background"  readonly="readonly" id="trabajadoreFechaNacimiento" placeholder="Seleccione fecha de nacimiento" ng-model="formulario.Trabajadore.fecha_nacimiento" ng-required="formulario.Trabajadore.estado=='Activo'">	
									</div>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Fecha_Ingreso.$valid }">
								<label class="col-md-4 control-label baja">Fecha Ingreso</label>
								<div class="col-md-8">
									<div class="input">
										<input type="text" name="Fecha_Ingreso" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Seleccione fecha de ingreso" ng-model="formulario.Trabajadore.fecha_ingreso" ng-required="formulario.Trabajadore.estado=='Activo'">
									</div>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Gerencia.$valid }">
								<label class="col-md-4 control-label">Gerencia</label>
								<div class="col-md-8">
									<ui-select ng-model="formulario.Cargo.Area.gerencia_id" on-select="cambioGerencia($item, true)" name="Gerencia" ng-required="formulario.Trabajadore.estado=='Activo'">
										<ui-select-match placeholder="Selecciones una gerencia" allow-clear="true">
											{{$select.selected.nombre}}
										</ui-select-match>
										<ui-select-choices repeat="gerencia.id as gerencia in gerenciasList | filter: $select.search">
											<div ng-bind-html="gerencia.nombre | highlight: $select.search"></div>
										</ui-select-choices>
									</ui-select>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Area.$valid }">
								<label class="col-md-4 control-label">Área</label>
								<div class="col-md-8">
									<ui-select ng-model="formulario.Cargo.area_id" on-select="cambioArea($item, true)" name="Area" ng-required="formulario.Trabajadore.estado=='Activo'">
										<ui-select-match placeholder="Selecciones un aréa" allow-clear="true">
											{{$select.selected.nombre}}
										</ui-select-match>
										<ui-select-choices repeat="area.id as area in areasList | filter: $select.search">
											<div ng-bind-html="area.nombre | highlight: $select.search"></div>
										</ui-select-choices>
									</ui-select>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Cargo.$valid }">
								<label class="col-md-4 control-label">Cargo</label>
								<div class="col-md-8">
									<ui-select ng-model="formulario.Trabajadore.cargo_id" name="Cargo" ng-required="formulario.Trabajadore.estado=='Activo'">
										<ui-select-match placeholder="Selecciones un cargo" allow-clear="true">
											{{$select.selected.nombre}}
										</ui-select-match>
										<ui-select-choices repeat="cargo.id as cargo in cargosList | filter: $select.search">
											<div ng-bind-html="cargo.nombre | highlight: $select.search"></div>
										</ui-select-choices>
									</ui-select>
								</div>
							</div> 
							<div class="form-group" ng-class="{ 'has-error': !trabajadoresAdd.Estado.$valid }">
								<label class="col-md-4 control-label">Estado</label>
								<div class="col-md-8">
									<label class="radio-inline" ng-repeat="estado in estadosList" ng-if="estado.nombre!='Retirado'">
										<input type="radio" name="Estado" ng-model="formulario.Trabajadore.estado" value="{{ estado.nombre }}" required> {{ estado.nombre }}
									</label>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="panel-footer">
					<button class="btn btn-primary btn-lg" ng-disabled="!trabajadoresAdd.$valid" ng-click="agregarTrabajador()"><i class="fa fa-pencil"></i> Registrar</button>
					<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/trabajadores',
		'angularjs/directivas/capitalize_input',
		'angularjs/servicios/trabajadores',
		'angularjs/servicios/areas/areas',
		'angularjs/servicios/cargos/cargos',
		'angularjs/servicios/gerencias/gerencias',
		'angularjs/factorias/areas/areas',
		'angularjs/factorias/cargos/cargos',
		'angularjs/factorias/trabajadores',
		'bootstrap-datepicker',
		'rut'
	));
?>