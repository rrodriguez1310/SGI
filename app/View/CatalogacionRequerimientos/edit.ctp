<div ng-controller="catalogacionRequerimientosEdit" ng-cloak ng-init="requerimientoId(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Ingreso Requerimiento</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" novalidate name="catalogacionRequerimientosForm">
					<div class="panel panel-default">
						<div class="panel-heading"><h5>Requerimiento</h5></div>
						<div class="panel-body">
							<div class="form-group" ng-class="{ 'has-error': !(catalogacionRequerimientosForm.entregaFecha.$valid && catalogacionRequerimientosForm.entregaHora.$valid) }">
								<label for="fechaEntrega" class="col-md-3 control-label baja">Fecha Entrega</label>
								<div class="col-md-4">
									<div class="input">
										<input type="text" class="form-control readonly-pointer-background datepicker" name="entregaFecha" id="entregaFecha" ng-model="entrega_fecha" required readonly placeholder="Selecciona fecha">
									</div>
								</div>
								<label for="horaEntrega" class="col-md-2 control-label baja">Hora</label>
								<div class="col-md-3">
									<div class="input">
										<input type="text" class="form-control readonly-pointer-background clockpicker" name="entregaHora" id="entregaHora" ng-model="entrega_hora" required readonly placeholder="Selecciona hora">	
									</div>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.tipoDeRequerimiento.$valid }">
								<label for="tipoDeRequerimiento" class="col-md-3 control-label">Tipo de requerimiento</label>
								<div class="col-md-9">
									<select2 type="text" class="form-control" name="tipoDeRequerimiento" id="tipoDeRequerimiento" ng-model="formulario.CatalogacionRequerimiento.catalogacion_r_tipo_id" s2-options="tipoRequerimiento.id as tipoRequerimiento.nombre for tipoRequerimiento in tipoRequerimientosList track by tipoRequerimientosList.id" placeholder="Seleccione un tipo de requerimiento" required>
										<option></option>
									</select2>
								</div>
							</div>

							<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.detalleTipo.$valid }">
								<label for="fechaEntrega" class="col-md-3 control-label">Descripción</label>
								<div class="col-md-9">
									<select2 type="text" class="form-control" name="detalleTipo" id="detalleTipo" ng-model="detalle.tipo" s2-options="tipo.id as tipo.nombre for tipo in tiposList track by tipo.id" ng-required="formulario.CatalogacionRTag.length == 0" ng-change="cambioTipoDetalle()" placeholder="Selecciona tipo">
										<option value=""></option>
									</select2>
								</div>
							</div>
							
							<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.detalleTipo.$valid }">
								<label for="fechaEntrega" class="col-md-3 control-label">Tipo</label>
								<div class="col-md-9">
									<select2 type="text" class="form-control" name="detalleTipo" id="detalleTipo" ng-model="detalle.tipo" s2-options="tipo.id as tipo.nombre for tipo in tiposList track by tipo.id" ng-required="formulario.CatalogacionRequerimientosTag.length == 0" ng-change="cambioTipoDetalle()" placeholder="Selecciona tipo">
										<option value=""></option>
									</select2>
								</div>
							</div>
							<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.detalleValor.$valid }">
								<div ng-switch on="detalle.tipo">
									<div ng-switch-when="7">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<label class="radio-inline">
												<input type="radio" name="sino" id="sino" value="SI" ng-required="formulario.CatalogacionRTag.length == 0" ng-model="detalle.valor"> Si
											</label>
											<label class="radio-inline">
												<input type="radio" name="sino" id="sino" value="NO" ng-required="formulario.CatalogacionRTag.length == 0"  ng-model="detalle.valor"> No
											</label>
										</div>
									</div>
									<div ng-switch-when="9">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="(equipo.codigo+' - '+equipo.nombre) as (equipo.codigo+' - '+equipo.nombre) for equipo in equiposList track by equipo.nombre" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un equipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-when="10">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="(equipo.codigo+' - '+equipo.nombre) as (equipo.codigo+' - '+equipo.nombre) for equipo in equiposList track by equipo.nombre" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un equipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-when="3">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="publico for publico in publicoList" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un tipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-when="5">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="produccionCD for produccionCD in produccionCDFList" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un tipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-when="6">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="tipoImagen for tipoImagen in tipoImagenList" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un tipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-when="11">
										<label class="col-md-3 control-label">Valor</label>
										<div class="col-md-9">
											<select2 type="text" class="form-control" name="detalleValor" id="detalleValor" ng-model="detalle.valor" s2-options="tiposPlano for tiposPlano in tiposPlanoList" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Selecciona un tipo">
											<option></option>
										</select2>
										</div>
									</div>
									<div ng-switch-default>
									<label class="col-md-3 control-label baja">Valor</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="detalleValor" name="detalleValor" ng-model="detalle.valor" ng-required="formulario.CatalogacionRTag.length == 0" placeholder="Ingresa valor">
										</div>	
									</div>
								</div>							
							</div>
							<div class="form-group">
								<div class="col-md-12 text-center">
									<button class="btn btn-default" ng-click="agregarDetalle()" ng-disabled="!(!!detalle.tipo && !!detalle.valor)"><i class="fa fa-plus-circle"></i> Agregar</button>
								</div>	
							</div>
							<div class="form-gruop" ng-if="formulario.CatalogacionRTag.length != 0">
								<table class="table table-condensed">
									<thead>
										<tr>
											<th>Tipo</th>
											<th>Valor</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(key, valores) in formulario.CatalogacionRTag" ng-if="valores.estado==1">
											<td>{{ tiposPorId[valores.catalogacion_r_tags_tipo_id].nombre | uppercase }}</td>
											<td>{{ valores.valor }}</td>
											<td class="text-right"><a class="btn btn-danger btn-sm" ng-click="eliminarDetalle(key)"><i class="fa fa-trash-o"></i></a></td>
										</tr>
									</tbody>
								</table>
							</div>
							



							<div class="form-group">
								<div class="col-md-12">
									<label class="control-label" for="observacion">Observaciones</label>
									<textarea class="form-control" name="observacion" id="observacion" ng-model="formulario.CatalogacionRequerimiento.observacion" rows="5">
										
									</textarea>	
								</div>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading"><h5>Entrega</h5></div>
						<div class="panel-body">
							<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.tipoEntrega.$valid }">
								<div>
									<label for="fechaEntrega" class="col-md-3 control-label">Tipo de Entrega</label>
								</div>
								<div class="col-md-9">
									<select2 type="text" class="form-control" name="tipoEntrega" id="tipoEntrega" ng-model="tipoEntrega" s2-options="tipoEntrega.id as tipoEntrega.nombre for tipoEntrega in tipoEntregas track by tipoEntrega.id" placeholder="Seleccione un tipo de entrega" ng-change="cambioTipoEntrega(tipoEntrega)" required>
										<option></option>
									</select2>
								</div>
							</div>
							<div ng-switch on="tipoEntrega">
								<div ng-switch-when="0">
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.servidor.$valid }">
										<label class="control-label col-md-3" for="soporte">
											Servidor
										</label>
										<div class="col-md-9">
											<select2 class="form-control" ng-model="formulario.CatalogacionRDigitale.ingesta_servidore_id" id="servidor" name="servidor" placeholder="Seleccione un servidor" s2-options="servidor.id as servidor.nombre for servidor in servidoresList track by soporte.id" ng-required="tipoEntrega==0">
												<option value=""></option>
											</select2>	
										</div>
									</div>
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.nombreCarpeta.$valid }">
										<label class="control-label col-md-3 baja" for="nombreCarpeta">
											Nombre de carpeta
										</label>
										<div class="col-md-9">
											<input type="text" class="form-control" name="nombreCarpeta" id="nombreCarpeta" ng-model="formulario.CatalogacionRDigitale.ruta" ng-required="tipoEntrega==0">	
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="control-label" for="observacionEntrega">Observaciones</label>
											<textarea class="form-control" name="observacionEntrega" id="observacionEntrega" ng-model="formulario.CatalogacionRDigitale.observacion" rows="5">
												
											</textarea>	
										</div>
									</div>
								</div>
								<div ng-switch-when="1">
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.soporte.$valid }">
										<label class="control-label col-md-3" for="soporte">Soporte</label>
										<div class="col-md-9">
											<select2 class="form-control" ng-model="formulario.CatalogacionRFisico.soporte_id" id="soporte" name="soporte" placeholder="Seleccione un soporte" s2-options="soporte.id as soporte.nombre for soporte in soportesList track by soporte.id" ng-required="tipoEntrega==1">
												<option value=""></option>
											</select2>	
										</div>
									</div>
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.formato.$valid }">
										<label class="control-label col-md-3" for="formato">
											Formato
										</label>
										<div class="col-md-9">
											<select2 class="form-control" ng-model="formulario.CatalogacionRFisico.formato_id" id="formato" name="formato" placeholder="Seleccione un formato" s2-options="formato.id as formato.nombre for formato in formatosList track by formato.id" ng-required="tipoEntrega==1">
												<option value=""></option>
											</select2>	
										</div>
									</div>
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.copia.$valid }">
										<label class="control-label col-md-3" for="copia">
											Copia
										</label>
										<div class="col-md-9">
											<select2 class="form-control" ng-model="formulario.CatalogacionRFisico.copia_id" id="copia" name="copia" placeholder="Seleccione una copia" s2-options="copia.id as copia.copia for copia in copiasList track by copia.id" ng-required="tipoEntrega==1">
												<option value=""></option>
											</select2>	
										</div>
									</div>
									<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.logo.$valid }">
										<label class="control-label col-md-3" for="logo">
											Logo
										</label>
										<div class="col-md-9">
											<label class="radio-inline">
												<input type="radio" name="logo" id="logo" value="SI" ng-required="tipoEntrega==1" ng-model="formulario.CatalogacionRFisico.logo" ng-change="formulario.CatalogacionRFisico.logo_posicion = undefined"> Si
											</label>
											<label class="radio-inline">
												<input type="radio" name="logo" id="logo" value="NO" ng-required="tipoEntrega==1"  ng-model="formulario.CatalogacionRFisico.logo" ng-change="formulario.CatalogacionRFisico.logo_posicion = undefined"> No
											</label>
										</div>
									</div>
									<div ng-if="formulario.CatalogacionRFisico.logo=='SI'">
										<div class="form-group" ng-class="{ 'has-error': !catalogacionRequerimientosForm.posicionLogo.$valid }">
											<label class="control-label col-md-3" for="logo">
												Logo posición
											</label>
											<div class="col-md-9">
												<select2 class="form-control" ng-model="formulario.CatalogacionRFisico.logo_posicion" id="posicionLogo" name="posicionLogo" placeholder="Seleccione una posición para el logo" s2-options="logoPosicion.nombre as logoPosicion.nombre for logoPosicion in logoPosicionList track by logoPosicion.id" ng-required="formulario.CatalogacionRFisico.logo=='SI'">
													<option value=""></option>
												</select2>
											</div>	
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-12">
											<label class="control-label" for="observacionEntrega">Observación entrega</label>
											<textarea class="form-control" name="observacionEntrega" id="observacionEntrega" ng-model="formulario.CatalogacionR2Fisico.observacion" rows="5">
												
											</textarea>	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="(!catalogacionRequerimientosForm.$valid || (formulario.CatalogacionRequerimientosDetalle.length == 0)) || registrando" ng-click="registrarRequerimiento()"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_requerimientos", "action"=>"index"), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->css("bootstrap-clockpicker.min");
 	echo $this->Html->script(array(
 		"angularjs/controladores/app",
 		"angularjs/servicios/catalogacion_requerimientos/catalogacion_requerimientos",
 		"angularjs/factorias/copias/copias",
 		"angularjs/factorias/formatos/formatos",
 		"angularjs/factorias/soportes/soportes",
 		"angularjs/controladores/catalogacion_requerimientos/catalogacion_requerimientos",
 		//"angularjs/modulos/select2/angular-select2.min",
 		'bootstrap-datepicker',
 		"bootstrap-clockpicker.min",
		"select2.min"
 	)); 
?>