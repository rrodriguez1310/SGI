<style>
.table>tbody+tbody {border-top: 0px solid #ddd}
input {margin-top: 0px;}
</style>
<div ng-controller="objetivosEdit" ng-init="datosObjetivos(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?><?php if(isset($this->request->pass[1])){ echo ','.$this->request->pass[1]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="objetivos"> <!--toppad -->
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title" ng-hide="pasoCalibrar||pasoAgendar||pasoDialogo||pasoAgendarCita">
						<div style="display:inline">
							<div class="text-primary bold">
								<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
								Establecimiento Objetivos Clave de Desempeño (OCD) {{anioObjetivo}}
							</div>
						</div>
					</h3>
					<h3 class="panel-title" ng-show="pasoCalibrar||(!pasoAgendarCita&&!pasoDialogo&&!pasoDefinir)">
						<div class="text-info bold">
							<i class="fa fa-balance-scale fa-lg margin-r-10"></i>
							Calibración Objetivos Clave de Desempeño (OCD) {{anioObjetivo}}
						</div>
					</h3>
					<h3 class="panel-title" ng-show="pasoAgendarCita">
						<div class="text-info bold">
							<i class="fa fa-envelope-o fa-lg margin-r-10"></i>
							Agendar Reunión Comunicación OCD {{anioObjetivo}}
						</div>
					</h3>
					<h3 class="panel-title" ng-show="pasoDialogo">
						<div class="text-info bold">
							<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
							Comunicación Objetivos Clave de Desempeño (OCD) {{anioObjetivo}}
						</div>
					</h3>
				</div>
				<div class="panel-body">
					<div ng-show="!ocdFinalizado" >
						<input type="hidden" ng-if="formulario.Evaluacion.id">
						<!-- cabecera / instrucciones -->
						<div ng-show="pasoDialogo">
							<h4>Instrucciones </h4>
							<ul type=square>
								<li>Estimado/a, sugerimos guardar una copia de este documento para gestiones futuras.</li>
							</ul>
							<br>
						</div>	
						<div ng-show="(!pasoAgendarCita&&!pasoDialogo&&!pasoDefinir&&!pasoCalibrar)">
							<h4>Instrucciones </h4>
							<ul type=square>
								<li>Los OCD han sido calibrados. Recuerda que debes agendar reunión con el colaborador para realizar la comunicación de éstos.</li>
							</ul>
							<br>
						</div>	
						<div class="col-md-12">

							<div ng-show="pasoDefinir">
								<h4>Instrucciones Definir</h4>
								<ul type=square>
									<li>Debes definir y establecer los 3 Objetivos Clave de Desempeño (OCD) anuales al colaborador, los cuales se evaluarán en la Gestión de Desempeño {{anioObjetivo}}-{{anioHasta}}.</li>
									<li>Para ello, debes considerar los criterios de la Metodología SMART que se resumen a continuación.</li>
									<li>No olvides completar cada uno de los campos solicitados.</li>
									<li>Recuerda que los OCD deben ser calibrados y luego comunicados presencialmente al colaborador.</li>
								</ul>
								<br>
							</div>
							<div ng-show="pasoCalibrar">
								<h4>Instrucciones Calibrar</h4>
								<ul type=square>
									<li>Solicitamos calibrar los 3 Objetivos Clave de Desempeño (OCD) anuales de {{trabajador.nombre}}, los cuales se evaluarán en la Gestión de Desempeño {{anioObjetivo}}-{{anioHasta}}.</li>
									<li>Para ello, debes considerar los criterios de la Metodología SMART que se resumen a continuación.</li>
									<li>No olvides completar cada uno de los campos solicitados. En caso de cambio, debes incluir las observaciones pertinentes que argumenten la modificación.</li>
									<li>Recuerda que tienes un plazo de 5 días hábiles para completar esta etapa.</li>
								</ul>
								<br>
							</div>						
						</div>
						<div class="row" ng-hide="pasoDialogo">
							<div class="col-md-3" style="margin-right: 0px">
								<div class="panel panel-primary">
									<div class="panel-heading" role="tab">
										<h4 class="panel-title" style="color: #fff !important">
											Estás {{(pasoCalibrar)?'calibrando':'definiendo'}} OCD a:
										</h4>
									</div>
									<div class="panel-body">
										<div class="col-md-12" align="center">
											<div class="img-circle img-fondo-100" style="background-image:url({{trabajador.foto}})" width="100" height="100"></div>
											<div class="text-center warning text-primary" style="font-size:16px"><b>{{trabajador.nombre}}</b></div>
											<div class="text-center warning text-primary"> {{trabajador.cargo}}</div>
											<div class="text-center warning text-warning"> Familia de Cargos <br> {{trabajador.familia_cargo}}</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-9"> <!-- ng-if="pasoCompetencias" -->
								<div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab">
											<h4 class="panel-title">										 
												<i class="fa fa-object-group"></i>
												<a data-toggle="collapse" href="#collapseOne">
													<u>Metodología SMART para establecer Objetivos Clave de Desempeño</u>
												</a>
											</h4>
										</div>
										<div class="panel-body panel-collapse collapse in" id="collapseOne">
											<div class="table-responsive">
												<table class="table table-condensed" style="font-size: 12px;border-bottom:1px solid #ddd;margin-bottom:15px;margin-top:5px">								
													<tbody>
													<tr>
														<td class="bold success col-md-1 text-center">S</td>
														<td class="bold col-md-2 text-center">Específico</td>
														<td class="col-md-9">Resultados esperados redactados de manera específica, pero concreta, con frases concisas y claras.</td>
													</tr>
													<tr>
														<td class="bold success text-center">M</td>
														<td class="bold text-center">Medible</td>
														<td>Valores (indicadores) explícitos y medibles, que permitan controlar su cumplimiento o alcance.</td>
													</tr>
													<tr>
														<td class="bold success text-center">A</td>
														<td class="bold text-center">Alcanzable</td>
														<td>Parámetros desafiantes, que movilicen a incrementar el desempeño, pero alcanzables con recursos que se dispone.</td>
													</tr>
													<tr>
														<td class="bold success text-center">R</td>
														<td class="bold text-center">Relevante</td>
														<td>Relevantes y alineados con la estrategia de la empresa y sus proyectos.</td>
													</tr>
													<tr>
														<td class="bold success text-center">T</td>
														<td class="bold text-center">Tiempo Determinado</td>
														<td>Plazos definidos en el tiempo, con límite claro en el cual se conseguirá el objetivo y/o se revisará su avance.</td>
													</tr>
													</tbody>
												</table>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- colaborador comunicacion ocd-->
						<div class="panel panel-primary" ng-show="pasoDialogo">
							<div class="panel-heading" role="tab">
								<h4 class="panel-title">
									<i class="fa fa-user fa-lg margin-r-10"></i>									
									Datos Colaborador									
								</h4>
							</div>
							<div class="panel-body" id="collapseOne">
								<div class="table-responsive col-md-10">									
									<table ng-if="pasoDialogo" class="table table-condensed animate-if" style="margin-bottom: 0 !important">
										<thead>
											<tr>
												<td class="col-md-3 text-right text-primary"> <b>Nombre Colaborador</b> </td>
												<td class="col-md-7"><b>{{trabajador.nombre}}</b></td>
											</tr>
										</thead>
										<tr>
											<th class="col-md-3 text-right  text-primary">Cargo</th>
											<td class="col-md-7">{{trabajador.cargo}}</td>
										</tr>
										<tr>
											<th class="col-md-3 text-right  text-primary">
												<div class="has-warning">Familia Cargos</div>
											</th>
											<td class="col-md-7">{{trabajador.familia_cargo}}</td>
										</tr>
										<tr>
											<th class="col-md-3 text-right  text-primary">Jefatura</th>
											<td class="col-md-7">{{trabajador.jefatura}}</td>
										</tr>
									</table>									
								</div>
								<div ng-show="pasoDialogo" class="col-md-2">
									<div class="col-md-12">
										<div class="text-right">
											<button class="btn btn-primary" style="margin-top:0px" ng-click="imprimirPlantilla(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
											 	<i class="fa fa-download"></i>&nbsp;
												Descargar 
											</button>
											<!--button style="margin-top:0px" class="btn btn-success" ng-click="habilitarEdicion()">
											 	<i class="fa fa-pencil-square-o"></i>&nbsp;
												Modificar 
											</button-->
										</div><br>
									</div>
								</div>
							</div>
						</div>
						<!-- objetivos -->
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> Objetivos Clave de Desempeño (OCD) </h4>
							</div>

							<div class="panel-body">								
								<form class="form-horizontal" name="objetivosEdit" novalidate>
									<div class="col-md-12 bg-success table-responsive" style="padding-top:8px;padding-bottom:8px;border-bottom:1px solid #ddd">
										<div class="col-md-1 col-md-1"></div>
										<div class="bold" ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-3': 'col-md-4'">Descripción</div>
										<div class="col-md-3 col-xs-3 bold">Indicador</div>
										<div class="col-md-2 col-xs-2 bold">Fecha Límite</div>
										<div class="bold" ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-1': 'col-md-2'">{{(pasoCalibrar||pasoAgendar)? 'Pond.' : 'Ponderación' }}</div>
										<div class="col-md-2 bold" ng-show="pasoCalibrar||pasoAgendar">Observaciones</div>
									</div>
									<div ng-hide="!habilitarEditar&&pasoDialogo"> <!-- paso 2 con problemas ng-show="habilitarEditar"-->
										<div ng-repeat="objetivo in objetivos" class="col-md-12 container-fluid" style="padding-top: 8px;padding-bottom: 16px;border-bottom: 1px solid #ddd" 
											ng-hide="formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==3&&!pasoDialogo || (pasoDialogo&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id<3)" 
											ng-class="(pasoAgendar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==2&&formulario.EvaluacionesObjetivo[$index].observado_validador==1)? 'bg-danger': ''">
											<div>
												<div class="col-md-1"><b>{{objetivo.nombre_objetivo}}</b></div>
												<div ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-3': 'col-md-4'">
													<textarea type="text" class="form-control sube" name="Objetivo-{{$index}}" placeholder="Definición de Objetivo"
														ng-model="formulario.EvaluacionesObjetivo[$index].descripcion_objetivo" maxlength="1000" rows="5" ng-init="formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id" required 
														ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
													</textarea>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<div class="col-md-8">
															<input type="text" number-format decimals="1" negative="false" class="form-control sube" name="NivelObjetivo-{{$index}}" 
															placeholder="Indicador" ng-model="formulario.EvaluacionesObjetivo[$index].indicador" required 
															ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
														</div>
														<ui-select class="abajo col-md-4" ng-model="formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id" style="padding-left: 0px;" name="NivelObjetivo-{{$index}}" required 
														ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
															<ui-select-match placeholder=" -- ">
																 <span>{{$select.selected.simbolo}}</span>
															</ui-select-match>
															<ui-select-choices repeat="unidad.id as unidad in unidades | filter: $select.search">
																<div ng-bind-html="unidad.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
													</div>
												</div>
												<div class="col-md-2">
													<div class="input">
														<input ng-class="((pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar)? '':'readonly-pointer-background'" class="form-control datepicker abajo" id="fechaObjetivo-{{$index}}" name="fechaObjetivo-{{$index}}" 
														ng-model="formulario.EvaluacionesObjetivo[$index].fecha_limite_objetivo" placeholder="Seleccione fecha"	style="padding-left: 12px !important;" readonly required 
														ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
													</div>
												</div>
												<div ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-1': 'col-md-2'">
													<input type="text" number-format decimals="0" negative="false" maxlength="2" class="form-control sube" name="Ponderacion-{{$index}}" placeholder="Ponderación" ng-model="formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion"
														required ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
												</div>
												<div class="col-md-2 form-group" ng-class="{'has-error':(formulario.EvaluacionesObjetivo[$index].observado_validador==1&&!formulario.EvaluacionesObjetivo[$index].observacion)}" 
												ng-show="((pasoCalibrar||pasoAgendar)&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==2)">
													<textarea type="text" class="form-control sube" name="Observaciones" placeholder="Observaciones"
														ng-model="formulario.EvaluacionesObjetivo[$index].observacion" maxlength="1000" rows="5" 
														ng-required="formulario.EvaluacionesObjetivo[$index].observado_validador==1&&(!pasoDialogo)" 
														ng-disabled="(pasoCalibrar&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id==1)||pasoAgendar">
													</textarea>
												</div>												
											</div>
										</div>
									</div>
									
									<div ng-show="pasoDialogo&&!habilitarEditar">
										<div ng-repeat="objetivo in objetivos" class="col-md-12 container-fluid" style="padding-top: 8px;padding-bottom: 16px;border-bottom: 1px solid #ddd" 
											ng-hide="(pasoDialogo&&formulario.EvaluacionesObjetivo[$index].evaluaciones_etapa_id<3)">
											<div>
												<div class="col-md-1"><b>{{objetivo.nombre_objetivo}}</b></div>
												<div ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-3': 'col-md-4'">
													{{formulario.EvaluacionesObjetivo[$index].descripcion_objetivo}}
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<div class="col-md-8 text-right">
															{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id==1)? simboloUnidad[$index] :''}} 
															{{formulario.EvaluacionesObjetivo[$index].indicador | number:1}} 
															{{(formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id>1)? simboloUnidad[$index] :''}}
														</div>
													</div>
												</div>
												<div class="col-md-2">
													<div class="text-left">
														{{formulario.EvaluacionesObjetivo[$index].fecha_limite_objetivo}}
													</div>
												</div>
												<div ng-class="(pasoCalibrar||pasoAgendar)? 'col-md-1': 'col-md-2'" class="text-left">
													{{formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion}}%
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 bg-success table-responsive" style="padding-top: 8px">
										<div class="col-md-10 col-xs-10 bold">Total</div>
										<div class="col-md-2 col-xs-2 text-left bold">
											<p ng-class="{'error' : (totalPonderado!=limitPonderado)}">
												{{totalPonderado}}% 
											</p>
										</div>
									</div>
									<p>&nbsp;</p>
									<div class="hide" name="plantillaFinal">
										<?php echo $this->element('imprimir/evaluaciones_objetivos/objetivos_final'); ?>
									</div>
								</form>
								<!-- footer -->
								<div ng-hide="pasoAgendar||pasoDialogo">
									<div class="panel-footer text-right">
										<button class="btn btn-success" ng-click="registrarObjetivos()">
											<i class="fa fa-pencil"></i> 
											Guardar
										</button>
										<button class="btn btn-default" ng-class="{'btn-primary':objetivosEdit.$valid && ponderadoValido}" ng-disabled="!objetivosEdit.$valid || !ponderadoValido" 
										confirmed-click="enviarObjetivos()" ng-hide="nodoInicial"
										ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
											Enviar 
											<i class="fa fa-chevron-right"></i>
										</button>
										<button class="btn btn-primary" confirmed-click="agendarReunion()" ng-show="nodoInicial"
										ng-confirm-click="¿Deseas continuar? No podrás volver a esta etapa.">
											Agendar Reunión 
											<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div>
								<!--div ng-show="pasoDialogo&&!habilitarEditar">
									<div class="panel-footer text-right">
										<button class="btn btn-default" ng-class="{'btn-primary':objetivosEdit.$valid && ponderadoValido}" ng-disabled="!objetivosEdit.$valid || !ponderadoValido" 
										confirmed-click="enviarObjetivos()" 
										ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
											Enviar a colaborador
											<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div-->
								<div ng-show="pasoDialogo">
									<div class="panel-footer text-right">
										<button class="btn btn-default" ng-class="{'btn-primary':objetivosEdit.$valid && ponderadoValido}" ng-disabled="!objetivosEdit.$valid || !ponderadoValido" 
										confirmed-click="enviarAColaborador()" 
										ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
											Enviar a colaborador
											<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div>
								<div ng-show="pasoAgendar&&!ocdFinalizado">
									<div class="panel-footer text-right">
										<button class="btn btn-primary" confirmed-click="agendarReunion()"
										ng-confirm-click="¿Deseas continuar? No podrás volver a esta etapa.">
											Agendar Reunión 
											<i class="fa fa-chevron-right"></i>
										</button>
									</div>
								</div>
							</div><!-- panel-body -->
						</div>	<!-- panel-default -->
						<!-- EJECUTIVO BCI aldo barbera -->		
					</div>
					<div ng-if="mensaje" class="animate-if">
						<div class="alert alert-success" role="alert">
							<i class="fa fa-check fa-2x text-info"></i>
							<div class="bold" style="display:inline-block"> {{msgExito}}</div>
						</div>
						
						<div ng-show="!!msgExitoDetalle" class="alert alert-info">
							<i class="fa fa-info-circle"></i>
							<div style="display:inline-block"> {{msgExitoDetalle}}</div>
						</div>
						<br>
						<a href="<?php echo Router::url('/evaluaciones_objetivos', true); ?>{{(pasoCalibrar)?'/calibrar':''}}" class="btn btn-default btn-md center">
							<i class="fa fa-mail-reply-all"></i> Volver
						</a>
					</div>
					<div ng-show="pasoAgendarCita&&!mensaje" class="col-md-12 animate-show">
						<form class="form-horizontal" name="agendarCita" novalidate>
								<div class="form-group">
									<label class="col-md-2 control-label" for="Colaborador">Colaborador</label>
									<div class="col-md-8" style="margin-top: 7px !important;">
										<div class="input">
											{{trabajador.nombre}}
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label" for="fechaComunicacion">Fecha reunión</label>
									<div class="col-md-8">
										<div class="input">
											<input class="form-control datepicker readonly-pointer-background" id="fechaComunicacion" name="fechaComunicacion" ng-model="formulario.EvaluacionesTrabajadore.fecha_comunicacion" placeholder="Seleccione fecha" style="padding-left: 12px !important;" readonly required>
										</div>
									</div>
								</div>

								<div class="clockpicker form-group">
									<label class="col-md-2 control-label " for="Hora_reunion">Hora</label>
									<div class="input text col-md-8">
										<input type="text" name="Hora_comunicacion" class="form-control readonly-pointer-background" id="horaComunicacion" placeholder="Seleccione hora" ng-model="formulario.EvaluacionesTrabajadore.hora_comunicacion" required readonly>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label " for="Lugar_comunicacion">Lugar </label>
									<div class="col-md-8">
										<input class="form-control" name="Lugar_comunicacion" ng-model="formulario.EvaluacionesTrabajadore.lugar_comunicacion" required/>
									</div>
								</div>
								<p>&nbsp;</p>
						</form>
						<!-- footer agendar -->
						<div>
							<div class="panel-footer">																
								<button class="btn btn-default col-md-offset-9" ng-class="{'btn-primary': agendarCita.$valid}" ng-disabled="!(agendarCita.$valid)" confirmed-click="enviarCitaReunion()" 
								ng-confirm-click="Se enviará correo con invitación a Comunicación de OCD. ¿Deseas continuar?">
									Enviar<i class="fa fa-paper-plane margin-l-10"></i>
								</button>							
							</div>
						</div>
					</div>					
				</div>		


			</div>	
		</div>
	</div>
</div>

<?php 
echo $this->Html->css('bootstrap-clockpicker.min');
echo $this->Html->script(array(	
	'angularjs/controladores/app',
	'angularjs/servicios/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/controladores/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/directivas/number_format',
	'bootstrap-datepicker',
	'bootstrap-clockpicker.min',
	'angularjs/directivas/confirmacion'
	));
?>
