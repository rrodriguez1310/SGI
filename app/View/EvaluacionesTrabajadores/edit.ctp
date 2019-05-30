<div ng-controller="evaluacionesEdit" ng-init="datosEvaluacion(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="evaluacion">
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title text-info">
						<div class="text-muted" ng-class="{'text-primary bold':(pasoCompetencias||pasoObjetivos||pasoDialogo||evFinalizada)}" style="display:inline">
							<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoCompetencias"></i>
							1. {{evaluacionCompetencias}}							
						</div>
						<div class="text-muted" ng-class="{'text-primary bold':(pasoObjetivos||pasoDialogo||evFinalizada)}" style="display:inline">
							<i class="fa fa-angle-right margin-l-10 margin-r-10"></i>
							<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoObjetivos"></i>
							2. {{evaluacionObjetivos}}							
						</div>
						<div class="text-muted" ng-class="{'text-primary bold':pasoDialogo||evFinalizada}" style="display:inline">	
							<i class="fa fa-angle-right margin-l-10 margin-r-10"></i>
							<i class="fa fa-futbol-o fa-lg margin-r-10" ng-show="pasoDialogo"></i>
							3. {{evaluacionDialogo}}
						</div>
					</h3>
				</div>
				<div class="panel-body">
					<div ng-hide="evFinalizada">
						<form class="form-horizontal" name="evaluacionesEdit" novalidate>
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
															<td class="text-center success col-md-1"><div ng-bind-html="niveles.grafica"></div></td>
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
												<div ng-class="(imprimirEvaluacion||impEvaluacionFinal)? 'col-md-9':''">
													<table ng-if="pasoDialogo" class="table table-condensed animate-if" style="margin-bottom: 0 !important">
														<thead>
															<tr>
																<td class="col-md-4 text-right text-success"> <b>Puntaje Competencias</b> </td>
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
															<th class="col-md-4 text-right  text-success">Situación de Desempeño</th>
															<td class="col-md-8"><b>{{situacionDesemepeno}}</b></td>
														</tr>
													</table>
												</div>
												
												<div class="col-md-3">															

													<button ng-show="imprimirEvaluacion || impEvaluacionFinal" class="btn btn-success" style="width:120px" ng-click="imprimirPlantilla(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
													 	<i class="fa fa-print"></i>&nbsp;
														Imprimir 
													</button>

													<button ng-show="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==8" style="width:120px" class="btn btn-success" ng-click="habilitarEdicion()">
													 	<i class="fa fa-pencil-square-o"></i>&nbsp;
														Modificar 
													</button>

													<button ng-show="subirEvaluacion" class="btn btn-default" ngf-select ngf-multiple="multiple" ngf-change="settingFile(formulario.EvaluacionesTrabajadore.archivo)" ng-model="formulario.EvaluacionesTrabajadore.archivo">
														<i class="fa fa-paperclip"></i>&nbsp;
														Adjuntar
													</button>
													<div ng-if="formulario.EvaluacionesTrabajadore.archivo[0]||formulario.EvaluacionesTrabajadore.ruta_archivo" class="baja"> 
														{{formulario.EvaluacionesTrabajadore.archivo[0].name | limitTo: 18}} 
														{{formulario.EvaluacionesTrabajadore.archivo[0].name.length > 18 ? '...' : ''}}

												    	<a download href="<?php echo $this->webroot.'files'.DS.'evaluaciones_trabajadores'.DS;?>{{formulario.EvaluacionesTrabajadore.ruta_archivo}}" target="_blank" ng-hide="formulario.EvaluacionesTrabajadore.archivo[0].name">
												    		<b>{{formulario.EvaluacionesTrabajadore.ruta_archivo.split("/")[formulario.EvaluacionesTrabajadore.ruta_archivo.split("/").length -1] | limitTo: 18}}
												    		</b>
												    		{{formulario.EvaluacionesTrabajadore.ruta_archivo.split("/")[formulario.EvaluacionesTrabajadore.ruta_archivo.split("/").length -1].length > 18 ? '...' : '' }}
												    	</a>
												    	<div ng-show="(formulario.EvaluacionesTrabajadore.archivo[0].size/1000000>7.00)">
													    	<div style="display:inline">
													    		({{(formulario.EvaluacionesTrabajadore.archivo[0].size/1000000) | number:2}}MB)
													    	</div>
													    	<div class="error">
													    		Tamaño supera el límite
													    	</div>
												    	</div>
												    </div>
												</div>	

											</div>
										</div>											
									</div>
								</div>
							</div>
						<!-- evaluaciones -->	
							<div ng-if="pasoCompetencias||habilitarEditar">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionCompetencias}} </h4>
									</div>									
									<div class="panel-body"><!-- Competencias -->
										<table class="table" style="border-collapse: initial !important">		
											<thead>
												<tr class="success"> 
													<td colspan="3"><b>{{tituloCompetencia}}</b></td> 
												</tr>
											</thead>
											<tbody ng-repeat="competencia in competencias" style="border-top: 0 !important">
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
													<td>														
														<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetencia[$index].niveles_logro_id" ng-init="formulario.EvaluacionesCompetencia[$index].competencia_id = competencia.id" name="Nivel_Logro[$index]" style="width:220px" required>
															<ui-select-match placeholder=" -- Seleccione -- " closeOnSelect='false'>
																{{$select.selected.nombre}}
															</ui-select-match>
															<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search" position="down">
																<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
															</ui-select-choices>
														</ui-select>
														
													</td>
												</tr>
											</tbody>
										</table>
									<!-- Competencias Generales -->
										<table class="table table-condensed">
											<tr class="success">
												<th class="col-md-9"> 
													{{tituloCompetenciaGenerales}}
												</th>
												<th class="col-md-3">  
													Nivel de Logro
												</th>											
											</tr>
											<tr ng-repeat="competenciaTransversal in competenciasGenerales"> 
												<td> {{competenciaTransversal.nombre}} </td>
												<td>
													<ui-select class="abajo" ng-model="formulario.EvaluacionesCompetenciasGenerale[$index].niveles_logro_id" ng-init="formulario.EvaluacionesCompetenciasGenerale[$index].competencias_generale_id = competenciaTransversal.id" style="width:220px" required>
														<ui-select-match placeholder=" -- Seleccione -- ">
															{{$select.selected.nombre}}
														</ui-select-match>
														<ui-select-choices repeat="niveles.id as niveles in nivelesLogroPaso1 | filter: $select.search" position="down">
															<div ng-bind-html="niveles.nombre | highlight: $select.search"></div>
														</ui-select-choices>
													</ui-select>
												</td>		
											</tr>
										</table>
									</div> <!-- panel-body -->
								</div>	<!-- panel-default -->
							</div> <!-- paso Competencia -->
							<div ng-if="pasoObjetivos || habilitarEditar">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionObjetivos}} </h4>
									</div>

									<div class="panel-body">
										<div class="col-md-12 bg-success table-responsive" style="padding-top:8px;padding-bottom:8px;border-bottom:1px solid #ddd">
											<div class="col-md-1"></div>
											<div class="col-md-3 bold">Descripción</div>
											<div class="col-md-2 bold text-right">Indicador</div>
											<div class="col-md-2 bold text-center">Fecha Límite</div>
											<div class="col-md-2 text-left bold">Puntaje</div>
											<div class="col-md-2 text-center bold">Ponderación</div>											
										</div>									
										<div>
											<div ng-repeat="objetivo in objetivos" class="col-md-12 container-fluid" style="padding-top: 8px;padding-bottom: 16px;border-bottom: 1px solid #ddd">
												<div>
													<div class="col-md-1"><b>{{objetivo.nombre}}</b></div>
													<div class="col-md-3">{{formulario.EvaluacionesObjetivo[$index].descripcion_objetivo}}</div>
													<div class="col-md-2 text-right">
														{{ (formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id==1)? simboloUnidad[formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id] :'' }} 
														{{ formulario.EvaluacionesObjetivo[$index].indicador | number:1}} 
														{{ (formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id>1)? simboloUnidad[formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id] :'' }}
													</div>
													<div class="col-md-2">
														<div class="text-center">{{formulario.EvaluacionesObjetivo[$index].fecha_limite_objetivo  | date : 'dd/MM/yyyy'}}</div>
													</div>
													<div class="col-md-2 text-center">
														<div class="form-group col-md-12" ng-if="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id>=8">
															<input type="number" class="form-control sube" name="NivelObjetivo-{{$index}}" placeholder="Puntaje" 
															ng-model="formulario.EvaluacionesObjetivo[$index].puntaje_modificado"
															required>
														</div>
														<div class="form-group " ng-if="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id<8" >
															<input type="number" class="form-control sube" name="NivelObjetivo-{{$index}}" placeholder="Puntaje" 
															ng-model="formulario.EvaluacionesObjetivo[$index].puntaje"
															required>
														</div>
													</div>
													<div class="col-md-2 text-center">
														{{formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion}}%
													</div>													
												</div>
											</div>
										</div>										
									</div><!-- panel-body -->	
								</div>	<!-- panel-default -->					
							</div> <!-- paso Objetivos -->			

							<div ng-if="pasoDialogo">
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-user fa-lg margin-r-10"></i> {{evaluacionDialogo}} </h4>
									</div>
									<div class="panel-body">
										<table class="table  table-condensed" ng-repeat="dialogo in dialogos">
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
													 ng-required="(dialogo.requerido==1&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3)||formulario.EvaluacionesTrabajadore.evaluaciones_estado_id!=3"></textarea>
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
									<button class="btn btn-success" ng-click="editarEvaluacion(1)">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary':evaluacionesEdit.$valid}" ng-disabled="(!evaluacionesEdit.$valid)" confirmed-click="siguienteEvaluacion(1)" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Siguiente 
										<i class="fa fa-chevron-right"></i>
									</button>
								</div>
							</div>

							<div ng-if="pasoObjetivos">
								<table class="table  table-condensed">
									<tr>
										<th class="col-md-8 success"> PUNTAJE</th>
										<th class="col-md-2 success">{{puntajeObjetivos | number:2}}</th>
										<th class="col-md-2 success text-center"> 
											<p ng-class="{'error' : (ponderacionObjetivos!=maxPonderacionTotal) }">
											{{ponderacionObjetivos}}% </p>
										</th>
									</tr>	
								</table>
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="editarEvaluacion(2);">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary': (evaluacionesEdit.$valid && ponderacionObjetivos==maxPonderacionTotal) }" ng-disabled="!(evaluacionesEdit.$valid && ponderacionObjetivos==maxPonderacionTotal)" confirmed-click="siguienteEvaluacion(2)" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Siguiente 
										<i class="fa fa-chevron-right"></i>
									</button>
								</div>
							</div>
							<!-- dialogo 1 -->
							<div ng-if="pasoDialogo&&!subirEvaluacion">
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="editarEvaluacion(3)">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button ng-hide="formulario.EvaluacionesTrabajadore.nodo_inicial&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3" class="btn btn-default" ng-class="{'btn-primary':evaluacionesEdit.$valid}" ng-disabled="!evaluacionesEdit.$valid"
									ng-click="enviarEvaluacion()">
										<i class="fa fa-share-square-o"></i> Enviar
									</button>
									<button ng-show="formulario.EvaluacionesTrabajadore.nodo_inicial&&formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==3" class="btn btn-default" ng-class="{'btn-primary':evaluacionesEdit.$valid}" ng-disabled="!evaluacionesEdit.$valid" confirmed-click="siguienteEvaluacion()" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Agendar reunión <i class="fa fa-share-square-o"></i>
									</button>
								</div>
							</div>

							<!-- post respuesta dialogo -->
							<div ng-if="subirEvaluacion">
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="editarEvaluacion()">
										<i class="fa fa-pencil"></i> Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary':evaluacionesEdit.$valid}" 
									ng-disabled="!evaluacionesEdit.$valid" confirmed-click="finalizarEvaluacion()" 
									ng-confirm-click="No podrás realizar cambios posteriores en esta evaluación de desempeño. ¿Deseas continuar?">
										<i class="fa fa-check"></i>	Finalizar 
									</button>
								</div>
							</div>
						
							<!-- documento final -->
							<div class="hide" name="plantillaFinal">
								<?php echo $this->element('imprimir/evaluaciones_trabajadores/evaluacion_final'); ?>
							</div>

							<div class="hide" name="plantilla">
								<?php echo $this->element('imprimir/evaluaciones_trabajadores/evaluacion_evaluador'); ?>
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
	'angularjs/directivas/solo_numeros',
	'angularjs/directivas/capitalize_input',
	'bootstrap-datepicker',	
	'bootstrap-clockpicker.min'
	));
?>
