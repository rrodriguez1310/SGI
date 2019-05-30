<div ng-controller="evaluacionesView" ng-init="datosEvaluacion(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0];}?>)" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="evaluacion">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">
					<div class="text-info bold">
						<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
						Detalle de Evaluación de Desempeño
					</div>
				</h3>
			</div>
			<div class="panel-body">
				<div class="col-md-12 col-lg-12" ng-hide="evFinalizada">
					<form class="form-horizontal" name="evaluacionesEdit" novalidate>
						<input type="hidden" ng-if="formulario.Trabajadore.id">
						<div class="panel-group" role="tablist" aria-multiselectable="true" style="margin-bottom: 20px">
							<div class="panel panel-primary">
								<div class="panel-heading" role="tab">
									<h4 class="panel-title text-primary" style="color: #fff !important">
										<i class="fa fa-line-chart fa-lg margin-r-10"></i>
										Resultados
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
										<table class="table" style="margin-bottom: 0 !important">
											<thead>
												<tr>
													<td class="col-md-4 text-right text-primary"><b>Jefatura</b></td>
													<td class="col-md-8">{{trabajador.jefatura}}</td>
												</tr>	
											</thead>		
											<tr>
												<th class="col-md-4 text-right text-primary">Puntaje Competencias</th>
												<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</td>
											</tr>
											<tr>
												<th class="col-md-4 text-right text-primary">Puntaje Objetivos</th>
												<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}</td>
											</tr>
											<tr>
												<th class="col-md-4 text-right text-primary">
													<div class="has-warning">Puntaje Ponderado</div>
												</th>
												<td class="col-md-8">{{formulario.EvaluacionesTrabajadore.puntaje_ponderado | number:2}}</td>
											</tr>
											
											<tr>
												<td class="col-md-4 text-right text-primary"><b>Situación de Desempeño</b></td>
												<td class="col-md-8"><b>{{situacionDesemepeno}}</b></td>
											</tr>
											<!--gau tr ng-show="formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==12&&!pasoAdjuntarArchivo">
												<th class="col-md-4 text-right text-primary"><div style="margin-top:3px">Archivo adjunto</div></th>
												<td class="col-md-8">
													<div style="width:200px">
									    			{{formulario.EvaluacionesTrabajadore.ruta_archivo.split("/")[formulario.EvaluacionesTrabajadore.ruta_archivo.split("/").length -1] | limitTo: 18}}										    		
											    	{{formulario.EvaluacionesTrabajadore.ruta_archivo.split("/")[formulario.EvaluacionesTrabajadore.ruta_archivo.split("/").length -1].length > 18 ? '...' : '' }}

											    	<a download href="<?php echo $this->webroot.'files'.DS.'evaluaciones_trabajadores'.DS;?>{{formulario.EvaluacionesTrabajadore.ruta_archivo}}" ng-hide="formulario.EvaluacionesTrabajadore.archivo[0].name" class="btn-sm btn btn-primary tool" data-original-title="Ver">
														<i class="fa fa-download"></i>
											    	</a>
											    	</div>											    	
											    													
												</td>
											</tr>
											<tr ng-show="pasoAdjuntarArchivo">
												<th class="col-md-4 text-right text-primary">
													<div class="text-right">
														<button class="btn btn-default sube text-right" ngf-select ngf-multiple="multiple" ngf-change="settingFile(formulario.EvaluacionesTrabajadore.archivo)" ng-model="formulario.EvaluacionesTrabajadore.archivo" type="file">
															Adjuntar archivo
														</button>
													</div>	
												</th>
												<td class="col-md-8">
													<div ng-if="formulario.EvaluacionesTrabajadore.archivo[0]||formulario.EvaluacionesTrabajadore.ruta_archivo" class="baja col-md-7" > 
														{{formulario.EvaluacionesTrabajadore.archivo[0].name | limitTo: 18}} 
														{{formulario.EvaluacionesTrabajadore.archivo[0].name.length > 18 ? '...' : ''}}
												    	
												    	<div ng-show="(formulario.EvaluacionesTrabajadore.archivo[0].size/1000000>7.00)">
													    	<div style="display:inline">
													    		({{(formulario.EvaluacionesTrabajadore.archivo[0].size/1000000) | number:2}}MB)
													    	</div>
													    	<div class="error">
													    		Tamaño supera el límite
													    	</div>
												    	</div>
												    </div>		
											    </td>
											</tr-->	
										</table>										
									</div>											
									<!--div class="col-md-2">		
										<button ng-show="pasoAdjuntarArchivo" class="btn btn-success" style="width:129px" ng-click="imprimirPlantilla(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
										 	<i class="fa fa-print"></i>&nbsp;
											Imprimir 
										</button>
									</div>
									<div ng-show="pasoAdjuntarArchivo" class="col-md-12 text-center">
										<p>&nbsp;</p>
										<button class="btn btn-success btn-lg" ng-disabled="!formulario.EvaluacionesTrabajadore.archivo[0].name||(formulario.EvaluacionesTrabajadore.archivo[0].size/1000000>7.00)" ng-click="subirArchivo()">
											<i class="fa fa-check-square-o fa-lg"></i>
											Finalizar
										</button>
										<p>&nbsp;</p>
									</div-->								
								</div>
								
							</div>
						</div>

					<!-- paso Competencias -->
						<div ng-hide="pasoConfirmarEvaluacion">
							<div> 								

								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionCompetencias}} </h4>
									</div>
									<div class="panel-body">	
									<!-- Competencias -->
										<table class="table" style="border-collapse: initial !important;margin-bottom:3px">		
											<!--thead>
												<tr class="success"> 
													<td colspan="3"> <b>{{tituloCompetencia}} </b></td> 
												</tr>
											</thead-->
											<tbody ng-repeat="competencia in competencias">
												<tr ng-show="{{!!competencia.grupos_competencia}}">
													<td class="col-md-9 success"> 
														<b>{{competencia.grupos_competencia}}</b>
													</td>
													<th class="col-md-3 success text-center"> 
														Nivel de Logro
													</th>
												</tr>
												<tr ng-class="(formulario.EvaluacionesCompetencia[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && !formulario.EvaluacionesCompetencia[$index].validado)? 'danger' : '' ">
													<td>{{competencia.nombre}}</td>
													<td class="text-center">{{nivelLogros1Nombre[formulario.EvaluacionesCompetencia[$index].niveles_logro_id]}}</td>
												</tr>
											</tbody>
											<!--tfoot>
												<tr class="success">
													<th class="col-md-9">PUNTAJE</th>
													<th class="col-md-3 text-center">{{porcentajeLogradoCompetencias | number:0}}%</th>
												</tr>
											</tfoot-->
										</table>
									<!-- Competencias Generales -->
										<table class="table">
											<tr class="success">
												<th class="col-md-9">
													{{tituloCompetenciaGenerales}}
												</th>
												<th class="col-md-3 text-center">
													Nivel de Logro
												</th>												
											</tr>
											<tr ng-repeat="competenciaTransversal in competenciasGenerales" ng-class="(formulario.EvaluacionesCompetenciasGenerale[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && !formulario.EvaluacionesCompetenciasGenerale.validado)? 'danger' : '' ">
												<td> {{competenciaTransversal.nombre}} </td>
												<td class="text-center">{{nivelLogros1Nombre[formulario.EvaluacionesCompetenciasGenerale[$index].niveles_logro_id]}}</td>
											</tr>
											<!--tfoot>
												<tr class="success">
													<th class="col-md-9">PORCENTAJE</th>
													<th class="col-md-3 text-center">{{porcentajeLogradoCompetenciasGen | number:0}}%</th>
												</tr>
											</tfoot-->
											<tfoot>
												<tr class="success">
													<th class="col-md-9">PUNTAJE</th>
													<th class="col-md-3 text-center">{{formulario.EvaluacionesTrabajadore.puntaje_competencias | number:2}}</th>
												</tr>
											</tfoot>
										</table>
									</div> <!-- panel-body -->
								</div>	<!-- panel-default -->
							</div>

							<!-- paso Objetivos -->
							<div> 	
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> {{evaluacionObjetivos}} </h4>
									</div>
									<div class="panel-body">
								<!-- Objetivos-->								
										<table class="table " style="margin-bottom: 0 !important">
											<thead>
												<tr class="success"> 
													<th colspan="2" class="col-md-8 success"> Objetivos Clave de Desempeño (OCD)</th> 
													<th class="col-md-2 success text-center"> Puntaje </th> 
													<th class="col-md-2 success text-center"> Ponderación </th> 
												</tr>
											</thead>
											<tbody ng-repeat="objetivo in objetivos">										
												<tr ng-class="(formulario.EvaluacionesObjetivo[$index].observado_validador==1 && formulario.EvaluacionesTrabajadore.evaluaciones_estado_id==5 && !formulario.EvaluacionesObjetivo[$index].validado)? 'danger' : '' ">
													<th class="col-md-2 success text-center">														
														{{objetivo.nombre}}
													</th>
													<td class="col-md-6">
														<div class="form-group col-xs-12">
															<div>{{formulario.EvaluacionesObjetivo[$index].descripcion_objetivo}}</div>
														</div>
													</td>
													<!--td class="col-md-3 text-center">
														{{nivelLogros2Nombre[formulario.EvaluacionesObjetivo[$index].niveles_logro_id]}}
													</td-->
													<td class="col-md-2 text-center">
														{{formulario.EvaluacionesObjetivo[$index].puntaje_modificado}}
													</td>
													<td class="col-md-2 text-center">
														{{formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion}}%
													</td>
												</tr>
											</tbody>
										</table>

										<table class="table">
											<!--tr>
												<th class="col-md-9 success"> PORCENTAJE</th>
												<th class="col-md-3 success text-center">{{porcentajeLogradoObjetivos | number:0}}%</th>
											</tr-->
											<tr>
												<th class="col-md-8 success" colspan="2"> PUNTAJE</th>
												<th class="col-md-2 success text-center">
													{{formulario.EvaluacionesTrabajadore.puntaje_objetivos | number:2}}
												</th>
												<th class="col-md-2 success text-center">100%</th>
											</tr>
										</table>
									</div><!-- panel-body -->	
								</div>	<!-- panel-default -->		
							</div> 		

							<!-- paso Dialogo -->
							<div>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title"> <i class="fa fa-user fa-lg margin-r-10"></i></i> {{evaluacionDialogo}} </h4>
									</div>
									<div class="panel-body">
										<p>
											<b> Comentarios del Evaluador </b>
										</p>
										<table class="table" ng-repeat="dialogo in dialogos">
											<tr class="success"> 
												<td class="col-md-12 success"> 													
													<b>{{dialogo.nombre}}</b>
												</td> 
											</tr>
											<tr>
												<td class="col-md-12">
													<div> {{formulario.EvaluacionesDialogo[$index].comentario}}</div>
												</td>
											</tr>
										</table>
										<p>&nbsp;</p>
										<p>
											<b><i class="fa fa-pencil fa-lg margin-r-10"></i>Comentarios del Colaborador Evaluado</b>
										</p>	
										<table class="table">											
											<tr>
												<td class="col-md-12">
													{{formulario.EvaluacionesTrabajadore.comentario_trabajador}}
												</td>
											</tr>
										</table>
									</div><!-- panel-body -->	
								</div>	<!-- panel-default -->		
								<p>&nbsp;</p>
								<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center">
									<i class="fa fa-mail-reply-all"></i>  Volver  
								</a>
							</div> <!-- paso Competencia -->	
						</div>	

						<!-- documento final -->
						<div class="hide" name="plantillaFinal">
							<?php echo $this->element('imprimir/evaluaciones_trabajadores/evaluacion_final'); ?>
						</div>

					</form>					
				</div>	
				<div ng-if="mensaje" class="animate-if">
					<div class="alert alert-success" role="alert">
						<i class="fa fa-check fa-2x text-success"></i>
						<div class="bold" style="display:inline-block"> {{msgExito}}</div>
						<p>&nbsp;</p>
						<p><i class="fa fa-info-circle"></i> {{msgExitoDetalle}}</p>
					</div>
					<p>&nbsp;</p>
					<a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-md center">
						<i class="fa fa-mail-reply-all"></i>  Volver  
					</a>
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
	'bootstrap-datepicker',
	));
?>
