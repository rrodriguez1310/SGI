<div ng-controller="evaluacionesAdd" ng-init="datosNuevaEvaluacion(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="evaluacion"> <!--toppad -->
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">
						<div style="display:inline">						
							<div class="text-muted" ng-class="{'text-primary bold':(pasoCompetencias||pasoObjetivos||pasoDialogo||evFinalizada)}" style="display:inline">
								<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoCompetencias"></i>
								1. {{evaluacionCompetencias}}
							</div>
							<div class="text-muted" ng-class="{'text-primary bold':(pasoObjetivos||pasoDialogo||evFinalizada)}" style="display:inline">
								<i class="fa fa-angle-right margin-r-10 margin-l-10"></i>
								<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoObjetivos"></i>
								2. {{evaluacionObjetivos}}								
							</div>
							<div class="text-muted" ng-class="{'text-primary bold':pasoDialogo||evFinalizada}" style="display:inline">					
								<i class="fa fa-angle-right margin-r-10 margin-l-10"></i>
								<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoDialogo"></i>
								3. {{evaluacionDialogo}} 
							</div>
						</div>						
					</h3>				
				</div>	
				<div class="panel-body">
					<div ng-hide="evFinalizada">
						<form class="form-horizontal" name="evaluacionesAdd" novalidate>
							<input type="hidden" ng-if="formulario.Trabajadore.id">
							<!-- cabecera / instrucciones -->
							<div class="col-md-12">
								<div ng-show="pasoCompetencias">
									<h4>Instrucciones</h4>	
									<p>
										Evalúa cada una de las competencias, considerando los niveles de logro de desempeño que se muestran en la tabla a continuación. Es importante que leas detenidamente la descripción de cada uno de ellos.
									</p>					
									<p>&nbsp;</p>			
								</div>
								<div ng-show="pasoObjetivos">
									<h4>Instrucciones</h4>	
									<p>
										Redacta y evalúa los 3 Objetivos Clave de Desempeño (OCD) anuales establecidos para el colaborador, considerando como referencia los niveles de logro que se muestran en la tabla a continuación.
										<br>Selecciona el puntaje que represente de mejor modo el cumplimiento o alcance del objetivo (de 0 a 120). A su vez, pondera cada uno de ellos (total: 100%).
									</p>	
									<p>&nbsp;</p>							
								</div>								
							</div>
							<div class="row">
								<div class="col-md-3" style="margin-right: 0px">
									<div class="panel panel-primary">
										<div class="panel-heading" role="tab">
											<h4 class="panel-title" style="color: #fff !important">
												Estás evaluando a:
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
									<div ng-show="pasoCompetencias">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab">
												<h4 class="panel-title">										 
													<i class="fa fa-check-square-o"></i> 
													<a data-toggle="collapse" href="#collapseOne">
														<u>Niveles de Logro Evaluación Competencias</u>
													</a>
												</h4>
											</div>
											<div class="panel-body panel-collapse collapse in" id="collapseOne">
												<div class="table-responsive">
													<table class="table table-condensed" style="margin-bottom: 0 !important;font-size: 12px">
														<tr><!--th class="col-md-1 text-center success">Puntaje</th-->
															<th class="col-md-3 text-center success" colspan="2">Nivel de Logro</th>
															<th class="col-md-9 text-center success">Descripción</th>
														</tr>
														<tr ng-repeat="niveles in nivelesLogroPaso1">
															<td class="text-center success col-md-1"> <div ng-bind-html="niveles.grafica"></div></td>
															<td class="success col-md-2">{{niveles.nombre}}</td>
															<td class="col-md-9">{{niveles.definicion}}</td>
														</tr>
													</table>	
												</div>		
											</div>	
										</div>	
									</div>

									<div ng-show="pasoObjetivos">
										<div class="panel panel-default">
											<div class="panel-heading" role="tab">
												<h4 class="panel-title">										 
													<i class="fa fa-check-square-o"></i> 
													<a data-toggle="collapse" href="#collapseTwo">
														<u>Niveles de Logro Evaluación Objetivos</u>
													</a>
												</h4>
											</div>
											<div class="panel-body panel-collapse collapse in" id="collapseTwo">
												<div class="table-responsive">
													<table class="table table-condensed" style="margin-bottom: 0 !important;font-size: 12px">			
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
									</div>
									
									<div ng-show="pasoDialogo">
										<div class="panel panel-success">
											<div class="panel-heading" role="tab">
												<h4 class="panel-title text-success">				 
													<i class="fa fa-line-chart fa-lg"></i>
														Resultados
												</h4>
											</div>
											<div class="panel-body">
												<table ng-if="pasoDialogo" class="table table-condensed animate-if" style="margin-bottom: 0 !important">
													<thead>
														<tr>
															<td class="col-md-4 text-right text-success"><b>Puntaje Competencias</b></td>
															<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</td>
														</tr>
													</thead>
													<tr>
														<th class="col-md-4 text-right  text-success">Puntaje Objetivos</th>
														<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}</td>
													</tr>
													<tr>
														<th class="col-md-4 text-right  text-success">
															<div class="has-warning">Puntaje Ponderado</div>
														</th>
														<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_ponderado | number:2}}</td>
													</tr>
													<tr>
														<th class="col-md-4 text-right text-success">Situación de Desempeño</th>
														<td class="col-md-8"><b>{{situacionDesemepeno}}</b></td>
													</tr>
												</table>
											</div>
										</div>											
									</div>

								</div>
							</div>
						<!-- evaluaciones -->
							<div ng-if="pasoCompetencias">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionCompetencias}} </h4>
									</div>
									<div class="panel-body">
									
										<table class="table" style="border-collapse: initial !important">	
											<thead>
												<tr class="success"> 
													<td colspan="3"><b>{{tituloCompetencia}}</b></td> 
												</tr>
											</thead>	
											<tbody ng-repeat="competencia in competencias">
												<tr ng-show="{{!!competencia.grupos_competencia}}">
													<td class="col-md-9 success"> 
														<b>{{competencia.grupos_competencia}}</b>
													</td>
													<th class="col-md-3 success">
														Nivel de Logro
													</th>
												</tr>
												<tr>
													<td>{{competencia.nombre}}</td>
													<td id="estilo">
														<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetencia[$index].niveles_logro_id" ng-init="formulario.EvaluacionesCompetencia[$index].competencia_id = competencia.id" name="Nivel_Logro[$index]" style="width:220px">
															<ui-select-match placeholder=" -- Seleccione -- ">
																 <span>{{$select.selected.nombre}}</span>
															</ui-select-match>
															<div style="position: static !important;"></div>
															<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search" 
															>
																<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
															</ui-select-choices>
															
														</ui-select>
													</td>
												</tr>
											</tbody>
										</table>
										<table class="table table-condensed">
											<tr class="success">
												<th> {{tituloCompetenciaGenerales}} </th>										
												<th class="col-md-3 success">  Nivel de Logro </th>
											</tr>
											<tr ng-repeat="competenciaTransversal in competenciasGenerales"> 
												<td class="col-md-9"> {{competenciaTransversal.nombre}} </td>
												<td class="col-md-3">
													<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].niveles_logro_id" ng-init="formulario.EvaluacionesCompetenciasGenerale[$index].competencias_generale_id = competenciaTransversal.id" style="width:220px" required>
														<ui-select-match placeholder=" -- Seleccione -- ">
															{{$select.selected.nombre}}
														</ui-select-match>
														<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search" position="down">
															<div ng-bind-html="niveles.nombre | highlight: $select.search" ></div>							
														</ui-select-choices>
													</ui-select>											
												</td>
											</tr>
										</table>
									</div><!-- panel-body -->
								</div>	<!-- panel-default -->
							</div> <!-- paso Competencia -->

							<div ng-if="pasoObjetivos">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionObjetivos}} </h4>
									</div>
									<div class="panel-body">
										<table class="table table-condensed">										
											<tr class="success"> 
												<th colspan="2" class="col-md-8 success"> Objetivos Clave de Desempeño (OCD)</th> 
												<th class="col-md-2 success"> Puntaje </th> 
												<th class="col-md-2 success"> Ponderación </th> 
											</tr>																		
											<tbody ng-repeat="objetivo in objetivos">
												<tr>
													<td class="col-md-2 text-center success">
														<b>{{objetivo.nombre}}</b>
													</td>											
													<td class="col-md-6">
														<div class="form-group col-xs-12">
															<textarea type="text" class="form-control sube" name="Objetivo-{{$index}}" placeholder="Definición de Objetivo"
															 ng-model="formulario.EvaluacionesObjetivo[$index].descripcion_objetivo" maxlength="1000"
															 ng-init="formulario.EvaluacionesObjetivo[$index].objetivos_comentario_id = objetivo.id"
															 required></textarea>
														</div>
													</td>
													<td class="col-md-2">
														<div class="form-group col-md-12">
															<input type="number" class="form-control sube" name="NivelObjetivo-{{$index}}" placeholder="Puntaje"
															 ng-model="formulario.EvaluacionesObjetivo[$index].puntaje"		
															 required>
														</div>
													</td>
													<td class="col-md-2">
														<input type="number" class="form-control sube" name="Ponderacion-{{$index}}" placeholder="Ponderación" ng-model="formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion"
														required>
													</td>
												</tr>
											</tbody>										
										</table>
									</div><!-- panel-body -->	
								</div>	<!-- panel-default -->					
							</div> <!-- paso Objetivos -->	

							<div ng-if="pasoDialogo">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-user fa-lg margin-r-10"></i> {{evaluacionDialogo}} </h4>
									</div>
									<div class="panel-body">
										<table class="table table-condensed" ng-repeat="dialogo in dialogos">
											<tr class="success"> 
												<td class="col-md-12 success"> 
													<b>{{dialogo.nombre}}</b> {{dialogo.definicion}} 
												</td> 
											</tr>
											<tr>
												<td class="col-md-12">
													<textarea type="text" class="form-control sube" name="Dialogo-{{$index}}" placeholder="Ingrese comentarios"
													 ng-model="formulario.EvaluacionesDialogo[$index].comentario" maxlength="1000"
													 ng-init="formulario.EvaluacionesDialogo[$index].dialogos_comentario_id = dialogo.id"
													 ng-required="(dialogo.requerido==1&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3)"></textarea>
												</td>												
											</tr>									
										</table>	
									</div><!-- panel-body -->	
								</div>	<!-- panel-default -->					
							</div> <!-- paso Competencia -->

						<!-- footer -->
							<div ng-if="pasoCompetencias">
								<table class="table table-condensed">
									<tr class="success">
										<th class="col-md-9">PUNTAJE</th>
										<th class="col-md-3">
											{{formulario.EvaluacionesTrabajadore.puntaje_competencias}}
										</th>
									</tr>
								</table>
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="agregarEvaluacion(1);">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary':evaluacionesAdd.$valid}" 
									ng-disabled="!evaluacionesAdd.$valid" confirmed-click="siguienteEvaluacion(1)" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Siguiente <i class="fa fa-chevron-right"></i>
									</button>
								</div>
							</div>
							
							<div ng-if="pasoObjetivos">
								<table class="table table-condensed">
									<tr>
										<th colspan="2" class="col-md-8 success"> PUNTAJE </th>
										<th class="col-md-2 success">{{puntajeObjetivos | number:2}}</th>
										<th class="col-md-2 success"> <p ng-class="{'error' : (ponderacionObjetivos!=maxPonderacionTotal) }">
											{{ponderacionObjetivos}}% </p>
										</th>
									</tr>	
								</table>

								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="agregarEvaluacion(2);">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary': (evaluacionesAdd.$valid && ponderacionObjetivos==maxPonderacionTotal) }" ng-disabled="!(evaluacionesAdd.$valid && ponderacionObjetivos==maxPonderacionTotal)" confirmed-click="siguienteEvaluacion(2)" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Siguiente <i class="fa fa-chevron-right"></i>
									</button>
								</div>
							</div>

							<div ng-if="pasoDialogo">
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="agregarEvaluacion(3);">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button ng-hide="formulario.EvaluacionesTrabajadore.nodo_inicial&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3"  class="btn btn-default" ng-class="{'btn-primary':evaluacionesAdd.$valid}" ng-disabled="!evaluacionesAdd.$valid" confirmed-click="enviarEvaluacion()" ng-confirm-click="La evaluación de desempeño se enviará a {{trabajador.nombre_calibrador}} para su calibración. ¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Enviar <i class="fa fa-share-square-o"></i>
									</button>
									<button ng-show="formulario.EvaluacionesTrabajadore.nodo_inicial&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3" class="btn btn-default" ng-class="{'btn-primary':evaluacionesAdd.$valid}" ng-disabled="!evaluacionesAdd.$valid" confirmed-click="siguienteEvaluacion()" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Agendar reunión <i class="fa fa-share-square-o"></i>
									</button>
								</div>								
							</div>
						</form>
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
						
						<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-md center">
							<i class="fa fa-mail-reply-all"></i>  Volver  
						</a>
					</div>
				</div>
			</div>	
		</div>
	</div>
</div>

<?php 
echo $this->Html->script(array(	
	'angularjs/controladores/app',
	'angularjs/servicios/evaluaciones_trabajadores/evaluaciones',
	'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	'angularjs/directivas/confirmacion',
	'bootstrap-datepicker',
	));
?>
