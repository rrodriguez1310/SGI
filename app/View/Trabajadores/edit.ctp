<div ng-controller="trabajadoresEdit" ng-init="idTrabajador = <?php echo $id; ?>" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="editshow">
		<div class="error" style="display:none">
			<div class="col-md-10 col-md-offset-1 alert alert-danger" role="alert" >
				<div id="errores"></div>
				<ol></ol>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1 toppad" >    
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-4">
							<h3 class="panel-title"></h3>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="row">
						<form name="uploadFotos" novalidate>
							<div class="col-md-3 col-lg-3 " align="center">
								<a ngf-select name="file" ng-model="foto.archivo" class="thumbnail" href="" ngf-change="uploadFoto()" ngf-accept="'image/*'" accept="image/*">
									<img id="fotoUsuario" class="img-circle" alt="Usuario" ng-src="<?php echo $this->webroot.'files'. DS .'trabajadores'. DS ?>{{ formulario.Trabajadore.foto }}">
								</a>
							</div>
						</form>
						<div class=" col-md-9 col-lg-9 ">
							<form class="form-horizontal" name="trabajadoresEdit" novalidate>
								<input type="hidden" ng-model="formulario.Trabajadore.id">
								<input type="hidden" ng-model='formulario["CuentasCorriente"][0]["id"]'>
								<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab" id="headingOne">
											<h4 class="panel-title">
												 <a role="button" id="collapse1" href="" ng-click="collapsePersona()">
													Datos Personales
												</a>
											</h4>
										</div>
										<div id="collapseOne" class="panel-collapse" role="tabpanel" aria-labelledby="headingOne">
											<div class="panel-body">				 
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Rut.$valid }">
													<label class="col-md-4 control-label baja" for="TrabajadoreRut">Rut</label>
													<div class="col-md-7" >		
														<input ng-rut rut-format="live" rut-disabled="{{validacionRut}}" type="text" id="TrabajadoreRut" name="Rut" class="form-control" placeholder="Ingrese rut" maxlength="12" ng-model="formulario.Trabajadore.rut" ng-blur="validaRut()" required>        		
													</div>
													<div class="col-md-1">
														<div class="checkbox">
															<label>
																<input type="checkbox" ng-model="validacionRut" style="margin-top : 14px" ng-click="quitarValidarut()">
															</label>
														</div>
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Nombre.$valid }">
													<label class="col-md-4 control-label baja">Nombres</label>
													<div class="col-md-8">
														<input type="text" name="Nombre" class="form-control" placeholder="Ingrese nombre" ng-model="formulario.Trabajadore.nombre" required capitalize-directive>	
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Apellido_Paterno.$valid }">
													<label class="col-md-4 control-label baja">Apellido Paterno</label>
													<div class="col-md-8">
														<input type="text" name="Apellido_Paterno" class="form-control" placeholder="Ingrese apellidp paterno" ng-model="formulario.Trabajadore.apellido_paterno" required capitalize-directive>	
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Apellido_Materno.$valid }">
													<label class="col-md-4 control-label baja">Apellido Materno</label>
													<div class="col-md-8">
														<input type="text" name="Apellido_Materno" class="form-control" placeholder="Ingrese apellido materno" ng-model="formulario.Trabajadore.apellido_materno" required capitalize-directive>
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Fecha_Nacimiento.$valid }">
													<label class="col-md-4 control-label baja">Fecha Nacimiento</label>
													<div class="col-md-8">
														<div class="input">
															<input type="text" name="Fecha_Nacimiento" class="form-control readonly-pointer-background"  readonly="readonly" id="trabajadoreFechaNacimiento" placeholder="Ingrese apellido materno" ng-model="formulario.Trabajadore.fecha_nacimiento" required>	
														</div>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Nacionalidad</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.nacionalidade_id">
															<ui-select-match placeholder="Selecciones una nacionalidad">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="nacionalidad.id as nacionalidad in nacionalidadesList | filter: $select.search">
																<div ng-bind-html="nacionalidad.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Sexo</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.sexo">
															<ui-select-match placeholder="Selecciones un sexo">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="sexo.id as sexo in sexosList | filter: $select.search">
																<div ng-bind-html="sexo.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Estado Civil</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.estados_civile_id">
															<ui-select-match placeholder="Selecciones un estado civil">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="estadoCivil.id as estadoCivil in estadoCivilList | filter: $select.search">
																<div ng-bind-html="estadoCivil.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Dirección</label>
													<div class="col-md-8">		 
														<input type="text" class="form-control" placeholder="Ingrese una dirección" ng-model="formulario.Trabajadore.direccion">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Comuna</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.comuna_id">
															<ui-select-match placeholder="Selecciones una comuna">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="comunas.id as comunas in comunasList | filter: $select.search">
																<div ng-bind-html="comunas.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>	    			      	
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Telefono Fijo</label>
													<div class="col-md-8">	
														<input type="text" class="form-control tel_fijo" placeholder="Ingrese telefono fijo" ng-model="formulario.Trabajadore.telefono_particular">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Telefono Movil</label>
													<div class="col-md-8">	
														<input type="text" class="form-control tel_movil" placeholder="Ingrese telefono movil" ng-model="formulario.Trabajadore.telefono_movil">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Telefono Emergencia</label>
													<div class="col-md-8">	
														<input type="text" class="form-control tel_fijo" placeholder="Ingrese telefono de emergencias" ng-model="formulario.Trabajadore.telefono_emergencia">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Sistema Pensión</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.sistema_pensione_id">
															<ui-select-match placeholder="Selecciones un sistema de pensión">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="sistemaPension.id as sistemaPension in sistemaPensionesList | filter: $select.search">
																<div ng-bind-html="sistemaPension.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Sistema Salud</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.sistema_previsione_id">
															<ui-select-match placeholder="Selecciones un sistema de salud">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="sistemaPrevision.id as sistemaPrevision in sistemaPrevisionesList | filter: $select.search">
																<div ng-bind-html="sistemaPrevision.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Tipo moneda plan de salud</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.sistema_salud_moneda">
															<ui-select-match placeholder="Selecciones el tipo de moneda del plan de salud">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="tiposMoneda.id as tiposMoneda in tiposMonedasList | filter: $select.search">
																<div ng-bind-html="tiposMoneda.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Valor plan de salud</label>
													<div class="col-md-8">	
														<input type="text" class="form-control" placeholder="Ingrese valor de plan de salud" ng-model="formulario.Trabajadore.sistema_salud_valor" solo-numeros>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Nivel de educación</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.nivel_educacion_id">
															<ui-select-match placeholder="Selecciones el nivel educacional">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="nivelEducacion.id as nivelEducacion in nivelEducacionsList | filter: $select.search">
																<div ng-bind-html="nivelEducacion.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Banco</label>
													<div class="col-md-8">
														<ui-select name="banco" ng-model="formulario['CuentasCorriente'][0]['banco_id']">
															<ui-select-match placeholder="Seleccione un banco">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="bancos.id as bancos in bancosList | filter: $select.search">
																<div ng-bind-html="bancos.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Tipo Cuenta</label>
													<div class="col-md-8">
														<ui-select name="tipo_cuenta" ng-model="formulario['CuentasCorriente'][0]['tipos_cuenta_banco_id']">
															<ui-select-match placeholder="Seleccione un tipo de cuenta">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="tiposCuentaBancos.id as tiposCuentaBancos in tiposCuentaBancosList | filter: $select.search">
																<div ng-bind-html="tiposCuentaBancos.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">N° Cuenta</label>
													<div class="col-md-8">	
														<input class="form-control" type="text" name="cuenta" ng-model="formulario['CuentasCorriente'][0]['cuenta']" placeholder="Ingrese N° de cuenta">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Casa de estudios</label>
													<div class="col-md-8">	
														<input type="text" class="form-control" placeholder="Ingrese casa de estudios" ng-model="formulario.Trabajadore.estudios_institucion">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Titulo</label>
													<div class="col-md-8">	
														<input type="text" class="form-control" placeholder="Ingrese titulo" ng-model="formulario.Trabajadore.estudios_titulo">
													</div>
												</div>           
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a id="collapse3" href="" ng-click="collapseEmpresa()">
													Empresa
												</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse">
											<div class="panel-body"> 
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Fecha_Ingreso.$valid }">
													<label class="col-md-4 control-label baja">Fecha Ingreso</label>
													<div class="col-md-8"> 
														<div class="input">
															<input type="text" name="Fecha_Ingreso" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Seleccione fecha de ingreso" ng-model="formulario.Trabajadore.fecha_ingreso" ng-required="formulario.Trabajadore.estado=='Activo'">
														</div>		      	
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Fecha_indefinido.$valid }">
													<label class="col-md-4 control-label baja">Fecha Indefinido</label>
													<div class="col-md-8"> 
														<div class="input">
															<input type="text" name="Fecha_indefinido" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Seleccione fecha de indefinido" ng-model="formulario.Trabajadore.fecha_indefinido" ng-required="formulario.Trabajadore.tipo_contrato_id==1 || formulario.Trabajadore.tipo_contrato_id==4">
														</div>		      	
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Gerencia.$valid }">
													<label class="col-md-4 control-label">Gerencia</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Cargo.Area.gerencia_id" on-select="cambioGerencia($item, true)" name="Gerencia" required>
															<ui-select-match placeholder="Selecciones una gerencia">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="gerencia.id as gerencia in gerenciasList | filter: $select.search">
																<div ng-bind-html="gerencia.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Area.$valid }">
													<label class="col-md-4 control-label">Área</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Cargo.area_id" on-select="cambioArea($item, true)" name="Area" required>
															<ui-select-match placeholder="Selecciones un aréa">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="area.id as area in areasList | filter: $select.search" ui-disable-choice="area.gerencia_id == 2">
																<div ng-bind-html="area.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Cargo.$valid }">
													<label class="col-md-4 control-label">Cargo</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.cargo_id" name="Cargo" required>
															<ui-select-match placeholder="Selecciones un cargo">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="cargo.id as cargo in cargosList | filter: $select.search">
																<div ng-bind-html="cargo.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Jefe</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Jefe.trabajadore_id" on-select="cambioJefe($item)">
															<ui-select-match placeholder="Selecciones un jefe">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="jefe.id as jefe in jefesList | filter: $select.search">
																<div ng-bind-html="jefe.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
														<input type="hidden" ng-model="formulario.Trabajadore.jefe_id">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Lugar Trabajo</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.localizacione_id">
															<ui-select-match placeholder="Selecciones un lugar de trabajo">
																{{$select.selected.nombre}} | {{$select.selected.direccion}}
															</ui-select-match>
															<ui-select-choices repeat="localizacion.id as localizacion in localizacionesList | filter: $select.search">
																<div ng-bind-html="localizacion.nombre+' | '+localizacion.direccion | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Correo Electronico</label>
													<div class="col-md-8">
														<input type="text" class="form-control" placeholder="Ingrese Nombre" ng-model="formulario.Trabajadore.email">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Anexo</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="Anexo" maxlength="14" placeholder="Ingrese Nombre" ng-model="formulario.Trabajadore.anexo">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label baja">Móvil CDF</label>
													<div class="col-md-8">
														<input type="text" class="form-control" name="Movil_CDF" maxlength="14" placeholder="Ingrese Móvil CDF" ng-model="formulario.Trabajadore.movil_corporativo">
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Horario</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.horario_id">
															<ui-select-match placeholder="Selecciones un horario">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="horario.id as horario in horariosList | filter: $select.search">
																<div ng-bind-html="horario.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Tipo Contrato</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.tipo_contrato_id">
															<ui-select-match placeholder="Selecciones un tipo de contrato">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="tipoContrato.id as tipoContrato in tipoContratosList | filter: $select.search">
																<div ng-bind-html="tipoContrato.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Dimensión</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.dimensione_id">
															<ui-select-match placeholder="Selecciones una dimensión">
																{{$select.selected.codigo}} - {{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="dimension.id as dimension in dimensionesList | filter: $select.search">
																<div ng-bind-html="dimension.codigo+' - '+dimension.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label">Estado</label>
													<div class="col-md-8">
														<ui-select ng-model="formulario.Trabajadore.estado" ng-disabled="formulario.Trabajadore.estado=='Activo'">
															<ui-select-match placeholder="Selecciones un estado">
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="estado.id as estado in estadosList | filter: $select.search">
																<div ng-bind-html="estado.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="panel-group" style="margin-top:5px">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a id="collapse3" href="" ng-click="collapseDocumento()">Documentos</a>
										</h4>
									</div>
									<div id="collapseThree" class="panel-collapse">
										<div class="panel-body">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">Agregar Documentos</h3>
												</div>
												<div class="panel-body">
													<form class="form-horizontal" name="documentosAdd" novalidate>
														<div class="form-group" ng-class="{ 'has-error': !documentosAdd.Tipos_Documento.$valid }">
															<label class="col-md-4 control-label">Tipo documento</label>
															<div class="col-md-8">
																<ui-select ng-model="documentos.Documento.tipos_documento_id" name="Tipos_Documento" on-select="cambioTiposDocumentoId($item)" required>
																	<ui-select-match placeholder="Selecciones un tipo de documento">
																		{{$select.selected.nombre}}
																	</ui-select-match>
																	<ui-select-choices repeat="tipoDocumento.id as tipoDocumento in tiposDocumentosList | filter: $select.search">
																		<div ng-bind-html="tipoDocumento.nombre | highlight: $select.search"></div>
																	</ui-select-choices>
																</ui-select>
															</div>
														</div>
														<div class="form-group" ng-class="{ 'has-error': !documentosAdd.Fecha_Documento.$valid }">
															<label class="col-md-4 control-label baja">Fecha documento</label>
															<div class="col-md-8">
																<div class="input">  
																	<input type="text" ng-model="documentos.Documento.fecha_inicial"  name="Fecha_Documento" class="form-control readonly-pointer-background datepicker" placeholder = 'Seleccione fecha inicial' readonly="readonly" required ng-change="cambioFechaInicial()" />
																</div>			      	
															</div>
														</div>
														<div class="form-group" ng-show="fechaTermino" ng-class="{ 'has-error': !documentosAdd.Fecha_Termino.$valid }">
															<label class="col-md-4 control-label baja" ng-init="fechaTerminoLabel = 'Fecha termino'">{{ fechaTerminoLabel }}</label>
															<div class="col-md-8">
																<div class="input">  
																	<input ng-init= "fechaFinalPlaceHolder = 'Seleccione fecha final'" name="Fecha_Termino" id="fecha_termino"  type="text" ng-model="documentos.Documento.fecha_final" class="form-control readonly-pointer-background datepicker" placeholder = '{{ fechaFinalPlaceHolder }}' readonly="readonly" ng-required="fechaTermino"/>
																</div>			      	
															</div>
														</div>
														<div class="form-group" ng-show="motivoRetiro" ng-class="{ 'has-error': !documentosAdd.Motivo_Retiro.$valid }">
															<label class="col-md-4 control-label">Motivo retiro</label>
															<div class="col-md-8">
																<ui-select ng-model="documentos.Retiro.motivo_retiro" name="Motivo_Retiro" ng-required="motivoRetiro">
																	<ui-select-match placeholder="Selecciones un tipo de documento">
																		{{$select.selected.nombre}}
																	</ui-select-match>
																	<ui-select-choices repeat="motivoRetiro.id as motivoRetiro in motivoRetirosList | filter: $select.search">
																		<div ng-bind-html="motivoRetiro.nombre | highlight: $select.search"></div>
																	</ui-select-choices>
																</ui-select>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label baja" ng-init="descripcionLabel = 'Descripción'">{{ descripcionLabel }}</label>
															<div class="col-md-8">
																<input id="descripcion" ng-model="documentos.Documento.descripcion" type="text" class="form-control" placeholder="Ingrese descripción" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label baja">Adjuntar archivo</label>
															<div class="col-md-8">
																<input ngf-select ng-model="documentos.Documento.archivo" name="file" type="file">
															</div>
														</div>
														<div class="form-group text-center">
															<button ng-disabled="!documentosAdd.$valid" ng-click="subirArchivo()" class="btn btn-success"><i class="fa fa-upload"></i></i> Agregar</button>
														</div>
													</form>
													<h4 class="text-center">Documentos</h4>
													<div class="row">
														<div class="col-md-12">
															<div trabajadores-lista-documentos-directive>
																
															</div trabajadores-lista-documentos-directive>
															<div>
																<br>	
																<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ng-model="grid" class="grid"></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<!--div class="panel-group" style="margin-top:5px">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a id="collapse4" href="" ng-click="collapseDescripcion()">Descripción de cargo</a>
										</h4>
									</div>
									<div id="collapseCuatro" class="panel-collapse">
										<div class="panel-body">
											<div class="panel panel-info">
												<div class="panel-heading">
													<h3 class="panel-title">Agregar Documentos</h3>
												</div>
												<div class="panel-body">
													<form class="form-horizontal" name="documentosAdd" novalidate>
														
														
														
														<div class="form-group">
															<label class="col-md-4 control-label baja">Adjuntar archivo</label>
															<div class="col-md-8">
																<input ngf-select ng-model="documentos.descripcion" name="file" type="file">
															</div>
														</div>
														<div class="form-group text-center">
															<button ng-disabled="!documentosAdd.$valid" ng-click="uploadDescripcion()" class="btn btn-success"><i class="fa fa-upload"></i></i> Agregar</button>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div-->

						</div>
					</div>
				</div>
				<div class="panel-footer">
					<button class="btn btn-primary btn-lg" ng-disabled="!trabajadoresEdit.$valid" ng-click="editarTrabajador()" id="editButton"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
					<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default volver btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
					<button type="button" class="btn btn-warning btn-lg" ng-show="!trabajadoresEdit.$valid" ng-click="mensajeError()"><i class="fa fa-info"></i></button>
				</div>            
			</div>
		</div>
	</div>
	<modal visible="showModal">
		<form class="form-horizontal" name="formularioCambioEstado" novalidate>
			<div class="form-group" ng-class="{ 'has-error': !formularioCambioEstado.Nueva_fecha_ingreso.$valid }">
				<label class="col-md-4 control-label baja">Nueva fecha ingreso</label>
				<div class="col-md-8"> 
					<div class="input">
						<input type="text" name="Nueva_fecha_ingreso" class="form-control datepicker readonly-pointer-background" readonly="readonly" placeholder="Seleccione nueva fecha ingreso" ng-model="nuevaFechaIngreso.fecha_ingreso" required>
					</div>		      	
				</div>
			</div>
		</form>
		<div class="modal-footer">
	        <button type="button" class="btn btn-primary" ng-click="guardarCambioEstado()" ng-disabled="!formularioCambioEstado.$valid">Cambiar</button>
	        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar</button>
	    </div>
	</modal>
</div>

<?php 
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/directivas/trabajadores/trabajadores',
	'angularjs/directivas/solo_numeros',
	'angularjs/directivas/modal/modal',
	'angularjs/directivas/capitalize_input',
	'angularjs/servicios/servicios',
	'angularjs/servicios/trabajadores',
	'angularjs/servicios/documentos/documentos',
	'angularjs/factorias/areas/areas',
	'angularjs/factorias/cargos/cargos',
	'angularjs/factorias/trabajadores',
	'angularjs/controladores/trabajadores',
	'bootstrap-datepicker',
	'jquery.maskedinput'
	));
?>
