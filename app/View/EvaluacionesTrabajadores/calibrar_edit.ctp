<div ng-controller="evaluacionesEdit" ng-init="datosEvaluacion(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="evaluacion">
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title" ng-hide="pasoAgendarReunion">
						<div class="text-info bold">
							<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
							Calibración de Desempeño&nbsp;
						</div>
					</h3>
					<h3 class="panel-title" ng-show="pasoAgendarReunion">
						<div class="text-info bold">
							<i class="fa fa-envelope-o fa-lg margin-r-10"></i>
							Agendar Reunión Diálogo de Desempeño&nbsp;
						</div>
					</h3>
				</div>
				<div class="panel-body">
					<div class="col-md-12 col-lg-12" ng-hide="evFinalizada">
						<form class="form-horizontal" name="evaluacionesEdit" novalidate>
							<input type="hidden" ng-if="formulario.Trabajadore.id">
							<div ng-show="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==4">
								<h4>Instrucciones</h4>
								<p>
									En esta etapa puedes realizar cambios en los niveles de logro con que se ha evaluado las competencias y objetivos clave de desempeño. Considera la descripción de los niveles de logro de desempeño que se muestran en las tablas respectivas. <br>
									Debes incluir las observaciones pertinentes que argumenten la modificación. <br>
									Recuerda que tienes un plazo de {{diasPlazo}} días hábiles para completar esta etapa.
								</p>
								<p>&nbsp;</p>							
							</div>
							<div ng-show="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5">
								<h4>Instrucciones</h4>
								<p>
									La evaluación de desempeño de {{trabajador.nombre}} ha sido calibrada por {{trabajador.nombre_calibrador}} con observaciones.  Los cambios se encuentran destacados en esta pantalla.<br>
									Recuerda que debes agendar reunión con el colaborador para realizar el Diálogo de Desempeño.
								</p>
								<p>&nbsp;</p>
							</div>
						
							<div class="row">
								<div class="panel-group" role="tablist" aria-multiselectable="true" style="margin-bottom: 20px">
									<div class="panel" ng-class="(pasoAgendarReunion)? 'panel-success': 'panel-danger'">
										<div class="panel-heading" role="tab" ng-hide="pasoAgendarReunion">
											<h4 class="panel-title text-danger">
												<i class="fa fa-line-chart fa-lg margin-r-10"></i>
												Estás calibrando la evaluación de desempeño de :
											</h4>									
										</div>
										<div class="panel-heading" role="tab" ng-show="pasoAgendarReunion">
											<h4 class="panel-title text-success">
												<i class="fa fa-line-chart fa-lg margin-r-10"></i>
												Resumen evaluación de desempeño
											</h4>
										</div>
										<div class="panel-body">
											<div class="col-md-3">
												<div class="col-md-12" align="center">
													<div class="img-circle img-fondo-100" style="background-image:url({{trabajador.foto}})" width="100" height="100"></div>
													<div class="text-center text-primary" style="font-size:16px"><b>{{trabajador.nombre}}</b></div>
													<div class="text-center text-primary"> {{trabajador.cargo}}</div>
												</div>
											</div>
											<div class="table-responsive col-md-7">
												<table class="table table-condensed" style="margin-bottom: 0 !important">
													<thead>
														<tr>
															<td class="col-md-4 text-right" ng-class="(pasoAgendarReunion)? 'text-success': 'text-danger'"><b>Jefatura</b></td>
															<td class="col-md-8">{{trabajador.jefatura}}</td>
														</tr>
													</thead>
													<tr>
															<th class="col-md-4 text-right text-danger" ng-class="(pasoAgendarReunion)? 'text-success': 'text-danger'">Puntaje Competencias</th>
															<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</td>
														</tr>
													<tr>
														<th class="col-md-4 text-right text-danger" ng-class="(pasoAgendarReunion)? 'text-success': 'text-danger'">Puntaje Objetivos</th>
														<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}</td>
													</tr>
													<tr>
														<th class="col-md-4 text-right text-danger" ng-class="(pasoAgendarReunion)? 'text-success': 'text-danger'">
															<div class="has-warning">Puntaje Ponderado</div> 
														</th>
														<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_ponderado | number:2}}</td>
													</tr>
													<tr>
														<th class="col-md-4 text-right text-danger" ng-class="(pasoAgendarReunion)? 'text-success': 'text-danger'">Situación de Desempeño</th>
														<td class="col-md-8"><b>{{situacionDesemepeno}}</b></td>
													</tr>
												</table>										
											</div>

											<!--div class="col-md-2 animate-if" ng-if="pasoAgendarReunion">								
												<button class="btn btn-success" ng-click="imprimirPlantilla(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
												 	<i class="fa fa-print margin-r-10"></i>
													Imprimir 
												</button>
											</div-->
										</div>
									</div>
								</div>

							<!-- paso Competencias -->
								<div ng-hide="pasoAgendarReunion">
									<div> 	
										<div class="panel panel-default">
											<div class="panel-heading" role="tab">
												<h4 class="panel-title">										 
													<i class="fa fa-check-square-o margin-r-10"></i> 
													<a data-toggle="collapse" href="#collapseOne">
														<u>Niveles de Logro Evaluación Competencias</u>
													</a>
												</h4>
											</div>
											<div id="collapseOne" class="panel-body panel-collapse collapse">
												<div class="table-responsive">

													<table class="table  table-condensed" style="margin-bottom: 0 !important">
														<tr>
															<th class="col-md-12 success" colspan="3"> Familia {{trabajador.familia_cargo}}</th>
														</tr>
														<tr><!--td class="col-md-1 text-center success">PUNTAJE</td-->
															<td class="col-md-3 text-center success" colspan="2">Nivel de Logro</td>
															<td class="col-md-9 text-center success">Descripción</td>
														</tr>
														<tr ng-repeat="niveles in nivelesLogroPaso1">
															<td class="text-center success col-md-1"><div ng-bind-html="niveles.grafica"></div></td>
															<td class="success col-md-2">{{niveles.nombre}}</td>
															<td class="col-md-9">{{niveles.definicion}}</td>
														</tr>					
													</table>	
												</div>
											</div>							  
										</div>

										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionCompetencias}} </h4>
											</div>
											<div class="panel-body">
										<!-- Competencias -->
												
												<table class="table table-condensed">		
													<thead>
														<tr class="success"> 
															<th colspan="4"> {{tituloCompetencia}} </th> 
														</tr>
													</thead>
													<tbody ng-repeat="competencia in competencias">
														<tr ng-show="{{!!competencia.grupos_competencia}}">
															<td class="col-md-6 success"> 
																<b>{{competencia.grupos_competencia}}</b>
															</td>
															<th class="col-md-2 success"> 
																Nivel de Logro
															</th>
															<th class="col-md-2 success"> 
																Calibración
															</th>
															<th class="col-md-2 success"> 
																Observaciones 
															</th>
														</tr>
														<tr ng-class="(formulario.EvaluacionesCompetencia[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && !formulario.EvaluacionesCompetencia[$index].validado)? 'danger' : '' ">
															<td>{{competencia.nombre}}</td>
															<td>
																<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetencia[$index].niveles_anterior" 
																ng-init="formulario.EvaluacionesCompetencia[$index].competencia_id = competencia.id" 
																name="Nivel_Logro[$index]" style="width:205px" 
																ng-disabled="true" required>
																	<ui-select-match placeholder=" -- Seleccione -- ">
																		{{$select.selected.nombre}}
																	</ui-select-match>
																	<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search">
																		<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
																	</ui-select-choices>
																</ui-select>
															</td>
															<td>
																<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetencia[$index].niveles_logro_id" 
																ng-init="formulario.EvaluacionesCompetencia[$index].competencia_id = competencia.id" 
																name="Nivel_Logro[$index]" style="width:205px" 
																ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4" required>
																	<ui-select-match placeholder=" -- Seleccione -- ">
																		{{$select.selected.nombre}}
																	</ui-select-match>
																	<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search">
																		<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
																	</ui-select-choices>
																</ui-select>
															</td>
															<td>
																<div ng-class="(formulario.EvaluacionesCompetencia[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5)? ( (!formulario.EvaluacionesCompetencia[$index].observacion)? 'has-error' : 'has-success') : ''" class="form-group col-xs-12" style="width: inherit;">
																  	<textarea class="form-control sube" name="evalComp-{{$index}}" 
																  	ng-model="formulario.EvaluacionesCompetencia[$index].observacion" 
																  	ng-required="formulario.EvaluacionesCompetencia[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5" maxlength="1000"
																  	ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4">
																  	</textarea>
																</div>
																<!--div ng-if="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && formulario.EvaluacionesCompetencia[$index].observado_validador==1">
																	<input type="checkbox" ng-required="formulario.EvaluacionesCompetencia[$index].observado_validador==1" name="chkComp[$index]" ng-model="formulario.EvaluacionesCompetencia[$index].validado" ng-true-value="1" ng-false-value="0" style="width:15px;height:15px">
																</div-->
															</td>
														</tr>
													</tbody>
												</table>
											<!-- Competencias Generales -->
												<table class="table table-condensed" style="margin-bottom: 0 !important">
													<tr class="success">
														<th class="col-md-6">
															{{tituloCompetenciaGenerales}}
														</th>
														<th class="col-md-2">
															Nivel de Logro
														</th>
														<th class="col-md-2">
															Calibración
														</th>
														<th class="col-md-2">
															Observaciones
														</th>
													</tr>
													<tr ng-repeat="competenciaTransversal in competenciasGenerales" ng-class="(formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && !formulario.EvaluacionesCompetenciasGenerale[$index].validado)? 'danger' : '' ">
														<td> {{competenciaTransversal.nombre}} </td>
														<td>													
															<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].niveles_anterior" 
																ng-init="formulario.EvaluacionesCompetenciasGenerale[$index].competencia_id = competencia.id" 
																name="Nivel_Logro[$index]" style="width:205px" ng-disabled="true" required>
																	<ui-select-match placeholder=" -- Seleccione -- ">
																		{{$select.selected.nombre}}
																	</ui-select-match>
																	<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search">
																		<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
																	</ui-select-choices>
																</ui-select>
															</td>
														<td>
															<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].niveles_logro_id" 
															ng-init="formulario.EvaluacionesCompetenciasGenerale[$index].competencias_generale_id = competenciaTransversal.id" style="width:205px" 
															ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4" required>
																<ui-select-match placeholder=" -- Seleccione -- " >
																	{{$select.selected.nombre}}
																</ui-select-match>
																<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search" position="down">
																	<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
																</ui-select-choices>
															</ui-select>
														</td>
														<td>
															<div ng-class="(formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5)? ( (!formulario.EvaluacionesCompetenciasGenerale[$index].observacion)? 'has-error' : 'has-success') : ''" class="form-group col-xs-12" style="width: inherit;">
															  	<textarea class="form-control sube" name="evalCompG-{{$index}}" 
															  	ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].observacion" 
															  	ng-required="formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5" maxlength="1000"
															  	ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4" ></textarea>
															</div>
															<!--div ng-if="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1">
																<input type="checkbox" ng-required="formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1" name="chkCompGen[$index]" style="width:15px;height:15px"
																	ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].validado" ng-true-value="1" ng-false-value="0">
															</div-->
														</td>
													</tr>
												</table>

												<table class="table table-condensed">
													<tr class="success">
														<th class="col-md-6">PUNTAJE</th>
														<th class="col-md-2">{{puntajeCompetenciasAnterior}}</th>
														<th class="col-md-2">{{formulario.EvaluacionesTrabajadore.puntaje_competencias}}</th>
														<th class="col-md-2">&nbsp;</th>
													</tr>
												</table>
											</div> <!-- panel-body -->
										</div>	<!-- panel-default -->
									</div>

									<!-- paso Objetivos -->

									<div> 	
										<div class="panel panel-default">
											<div class="panel-heading" role="tab">
												<h4 class="panel-title">
													<i class="fa fa-check-square-o margin-r-10"></i>
													<a data-toggle="collapse" href="#collapseTwo">
														<u>Niveles de Logro Evaluación Objetivos</u>
													</a>
												</h4>
											</div>
											<div id="collapseTwo" class="panel-body panel-collapse collapse">
												<div class="table-responsive">
													<table class="table table-condensed" style="margin-bottom: 0 !important">
														<tr>
															<th class="col-md-3 text-center success" colspan="2">Nivel de logro</th>
															<th class="col-md-9 text-center success">Descripción</th>
														</tr>
														<tr ng-repeat="niveles in nivelesLogroPaso2">
															<td class="text-center success col-md-1">{{niveles.rango_inicio}}-{{niveles.rango_termino}}</td>
															<td class="success col-md-2">{{niveles.nombre}}</td>
															<td class="col-md-9">{{niveles.definicion}}</td>
														</tr>
													</table>
												</div>
											</div>
										</div>

										<div class="panel panel-default">
											<div class="panel-heading" role="tab" id="headingOne">
												<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionObjetivos}} </h4>
											</div>
											<div class="panel-body">
										<!-- Objetivos-->												
												<table class="table table-condensed">
													<thead>
														<tr class="success"> 
															<th colspan="2" class="col-md-6 success"> Objetivos Clave de Desempeño (OCD) </th> 
															<th class="col-md-2 success"> Nivel de Logro </th> 
															<th class="col-md-2 success"> Calibración </th> 
															<th class="col-md-2 success"> Observaciones </th> 
														</tr>
													</thead>
													<tbody ng-repeat="objetivo in objetivos">										
														<tr ng-class="(formulario.EvaluacionesObjetivo[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 )? 'danger' : '' "> <!-- && !formulario.EvaluacionesObjetivo[$index].validado -->
															<th class="col-md-1 text-center">																
																{{objetivo.nombre}} 
															</th>											
															<td class="col-md-5">
																<div class="form-group col-xs-12">
																	<textarea type="text" class="form-control sube" name="Objetivo-{{$index}}" placeholder="Definición de Objetivo"
																	 ng-model="formulario.EvaluacionesObjetivo[$index].descripcion_objetivo" maxlength="1000"
																	 ng-init="formulario.EvaluacionesObjetivo[$index].objetivos_comentario_id = objetivo.id"
																	 required ng-disabled="pasoCalibrar||formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4"></textarea>
																</div>
															</td>
															<td class="col-md-2">
																<div class="form-group col-md-12">
																	<input type="number" class="form-control sube" name="NivelObjetivo-{{$index}}" placeholder="Puntaje"
																	 ng-model="formulario.EvaluacionesObjetivo[$index].puntaje" ng-disabled="true"
																	 required>
																 </div>
															</td>
															<td class="col-md-2">
																<div class="form-group col-md-12">
																	<input type="number" class="form-control sube" name="NivelObjetivo-{{$index}}" placeholder="Puntaje"
																	 ng-model="formulario.EvaluacionesObjetivo[$index].puntaje_calibrado" ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4" required>
																 </div>
															</td>
															<td class="col-md-2">
																<div ng-class="(formulario.EvaluacionesObjetivo[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5)? ( (!formulario.EvaluacionesObjetivo[$index].observacion)? 'has-error' : 'has-success') : ''" class="form-group col-xs-12" style="width: initial;">
																	<textarea class="form-control sube" name="obsObjetivo-{{$index}}" ng-model="formulario.EvaluacionesObjetivo[$index].observacion" ng-required="formulario.EvaluacionesObjetivo[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=5" ng-disabled="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=4" maxlength="1000"></textarea>
																</div>
																<!--div ng-if="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && formulario.EvaluacionesObjetivo[$index].observado_validador==1">
																	<input type="checkbox" ng-required="formulario.EvaluacionesObjetivo[$index].observado_validador==1" name="chkObj[$index]" style="width:15px;height:15px"
																	ng-model="formulario.EvaluacionesObjetivo[$index].validado" ng-true-value="1" ng-false-value="0">
																</div-->
															</td>
														</tr>
													</tbody>
												</table>

												<table class="table  table-condensed">
													<tr>
														<th class="col-md-6 success"> PUNTAJE</th>
														<th class="col-md-2 success">{{ puntajeObjetivosAnterior | number:2}}</th>
														<th class="col-md-2 success">{{ puntajeObjetivos | number:2}} </th>
														<th class="col-md-2 success"> </th>
													</tr>
												</table>
											</div><!-- panel-body -->	
										</div>	<!-- panel-default -->					
									</div> 		
								</div>
							</form>			
							<div ng-show="pasoAgendarReunion">					
								<form class="form-horizontal" name="agendarCita" novalidate>
									<div class="col-lg-12">										
										<div>
											<label class="col-md-3 control-label baja" for="fechaReunion">Fecha reunión</label>
											<div class="col-md-9">
												<div class="input">
													<input class="form-control datepicker readonly-pointer-background" id="fechaReunion" name="fechaReunion" ng-model="formulario.EvaluacionesTrabajadore.fecha_reunion" placeholder="Seleccione fecha"	ng-required="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==7" style="padding: 12px !important;" readonly>
												</div>
											</div>
										</div>

										<div class="clockpicker">
											<label class="col-md-3 control-label baja" for="Hora_reunion">Hora</label>
											<div class="input text col-md-9">
												<input type="text" name="Hora_reunion" class="form-control readonly-pointer-background" id="horaReunion" placeholder="Seleccione hora" ng-model="formulario.EvaluacionesTrabajadore.hora_reunion" ng-required="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==7" readonly>
											</div>
										</div>	
										<div>
											<label class="col-md-3 control-label baja" for="Lugar_reunion">Lugar </label>
											<div class="col-md-9">										
												<input class="form-control" name="Mensaje_reunion" ng-model="formulario.EvaluacionesTrabajadore.lugar_reunion" ng-required="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==7"/>
											</div>									
										</div>
										<div>
											<label class="col-md-3 control-label baja" for="Mensaje_reunion">Mensaje </label>
											<div class="col-md-9">										
												<textarea class="form-control" name="Mensaje_reunion" ng-model="formulario.EvaluacionesTrabajadore.mensaje_reunion" maxlength="1000"></textarea>
											</div>
											<p>&nbsp;</p>
										</div>
									</div>
								
									<div class="panel-footer text-right">								
										<button class="btn btn-default" ng-class="{'btn-primary': agendarCita.$valid}" ng-disabled="!(agendarCita.$valid)" confirmed-click="enviarCitaReunion()" ng-confirm-click="Se enviará correo con invitación a diálogo de desempeño. ¿Deseas continuar?">
											Enviar <i class="fa fa-paper-plane margin-l-10"></i>
										</button>
									</div>
								</form>
							</div>
								
							<div class="hide" name="plantillaEvaluador">
								<?php echo $this->element('imprimir/evaluaciones_trabajadores/evaluacion_evaluador'); ?>
							</div>
						</div>
						
						<!-- botones paso calibracion -->
						<div class="panel-footer text-right" ng-show="pasoCalibrar">
							<button class="btn btn-success" ng-click="editarEvaluacion()">
								<i class="fa fa-pencil"></i> Guardar 
							</button>
							<button class="btn btn-default" ng-class="{'btn-primary': (evaluacionesEdit.$valid && ponderacionObjetivos==maxPonderacionTotal) }" ng-disabled="!(evaluacionesEdit.$valid || !ponderacionObjetivos==maxPonderacionTotal)" confirmed-click="enviarCalibracion()" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
								Enviar <i class="fa fa-paper-plane"></i>
							</button>

						</div>
					
						<div class="panel-footer text-right" ng-hide="pasoCalibrar || pasoAgendarReunion">
							<!--button class="btn btn-success" ng-click="editarEvaluacion()">
								<i class="fa fa-pencil"></i> Guardar
							</button-->&nbsp;
							<button class="btn btn-default" ng-class="{'btn-primary': (evaluacionesEdit.$valid && ponderacionObjetivos==maxPonderacionTotal) }" ng-disabled="!(evaluacionesEdit.$valid)" confirmed-click="siguienteEvaluacion()" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
								Agendar reunión <i class="fa fa-chevron-right"></i>
							</button>
						</div>
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
						<div>
							<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-md center" ng-hide="formulario.EvaluacionesTrabajadore.nodo_inicial">
								<i class="fa fa-mail-reply-all"></i>  Volver  
							</a>
							<a href="<?php echo $this->Html->url(array('controller' => 'evaluaciones_trabajadores', 'action' => 'evaluar')); ?>" class="btn btn-default btn-md center" ng-show="formulario.EvaluacionesTrabajadore.nodo_inicial">
								<i class="fa fa-mail-reply-all"></i>  Volver  
							</a>
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
	'angularjs/servicios/evaluaciones_trabajadores/evaluaciones',
	'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	'angularjs/directivas/confirmacion',
	'bootstrap-datepicker',
	'bootstrap-clockpicker.min'
	));
?>
