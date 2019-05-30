<style>
.table>tbody+tbody {border-top: 0px solid #ddd}
input {margin-top: 0px;}

</style>
<div ng-controller="objetivosAdd" ng-init="datosObjetivos(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-show="objetivos"> <!--toppad -->
		<div class="row">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h3 class="panel-title">
						<div style="display:inline">						
							<div class="text-primary bold">
								<i class="fa fa-futbol-o fa-lg margin-r-10"></i>
								Establecimiento Objetivos Clave de Desempeño (OCD) {{anioObjetivo}}
							</div>
						</div>						
					</h3>
				</div>	
				<div class="panel-body">
					<div ng-hide="ocdFinalizado">
						<form class="form-horizontal" name="objetivosAdd" novalidate>
							<input type="hidden" ng-if="formulario.Evaluacion.id">
							<!-- cabecera / instrucciones -->
							<div class="col-md-12">
								<div>
									<h4>Instrucciones</h4>
									<ul type=square>
										<li>Debes definir y establecer los 3 Objetivos Clave de Desempeño (OCD) anuales al colaborador, los cuales se evaluarán en la Gestión de Desempeño {{anioObjetivo}}-{{anioHasta}}.</li>
										<li>Para ello, debes considerar los criterios de la Metodología SMART que se resumen a continuación.</li>
										<li>No olvides completar cada uno de los campos solicitados.</li>
										<li>Recuerda que los OCD deben ser calibrados y luego comunicados presencialmente al colaborador.</li>
									</ul>
									<br>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3" style="margin-right: 0px">
									<div class="panel panel-primary">
										<div class="panel-heading" role="tab">
											<h4 class="panel-title" style="color: #fff !important">
												Estás definiendo OCD a:
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
														Metodología SMART para establecer Objetivos Clave de Desempeño
													</a>
												</h4>
											</div>
											<div class="panel-body panel-collapse collapse in" id="collapseOne">
												<div class="table-responsive">
													<table class="table table-condensed" style="font-size: 12px;border-bottom:1px solid #ddd;margin-bottom:15px;margin-top:5px">
														<tbody style="">
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
							<!-- objetivos -->
							<div class="panel panel-default" >
								<div class="panel-heading" role="tab" id="headingOne">
									<h4 class="panel-title"> <i class="fa fa-file-text-o fa-lg margin-r-10"></i> Objetivos Clave de Desempeño (OCD)  </h4>
								</div>
								<div class="panel-body">	

									<div class="col-md-12 bg-success table-responsive" style="padding-top: 8px;padding-bottom: 8px;border-bottom: 1px solid #ddd; ">
										<div class="col-md-1 col-md-1"></div>
										<div class="col-md-4 col-xs-4 bold">Descripción</div>
										<div class="col-md-3 col-xs-3 bold">Indicador</div>
										<div class="col-md-2 col-xs-2 bold">Fecha Límite</div>
										<div class="col-md-2 col-xs-2 bold">Ponderación</div>
									</div>									
									<div ng-repeat="objetivo in objetivos" class="col-md-12 container-fluid" style="padding-top: 8px;padding-bottom: 16px;border-bottom: 1px solid #ddd">
										<div>
											<div class="col-md-1"><b>{{objetivo.nombre}}</b></div>
											<div class="col-md-4">
												<textarea type="text" class="form-control sube" name="Objetivo-{{$index}}" placeholder="Definición de Objetivo"
													ng-model="formulario.EvaluacionesObjetivo[$index].descripcion_objetivo" maxlength="1000" rows="5"
													ng-init="formulario.EvaluacionesObjetivo[$index].objetivos_comentario_id = objetivo.id;formulario.EvaluacionesObjetivo[$index].evaluaciones_objetivo_estado_id=objetivo.evaluaciones_objetivo_estado_id;formulario.EvaluacionesObjetivo[$index].estado=objetivo.estado"
													required>
												</textarea>
											</div>
											<div class="col-md-3">
												<div class="form-group">
													<div class="col-md-8">
														<input type="text" number-format decimals="1" negative="false" class="form-control sube" name="NivelObjetivo-{{$index}}" 
														placeholder="Indicador" ng-model="formulario.EvaluacionesObjetivo[$index].indicador" required>	
													</div>
													<ui-select class="abajo col-md-4" ng-model="formulario.EvaluacionesObjetivo[$index].evaluaciones_unidad_objetivo_id" style="padding-left: 0px;" name="NivelObjetivo-{{$index}}" required>
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
													<input class="form-control datepicker readonly-pointer-background abajo" id="fechaObjetivo-{{$index}}" name="fechaObjetivo-{{$index}}" 
													ng-model="formulario.EvaluacionesObjetivo[$index].fecha_limite_objetivo" placeholder="Seleccione fecha"	style="padding-left: 12px !important;" readonly required>
												</div>
											</div>
											<div class="col-md-2">
												<input type="text" number-format decimals="0" negative="false" maxlength="2" class="form-control sube" name="Ponderacion-{{$index}}" placeholder="Ponderación" ng-model="formulario.EvaluacionesObjetivo[$index].porcentaje_ponderacion" 
													required>
											</div>
										</div>		
									</div>
									<div class="col-md-12 bg-success table-responsive" style="padding-top: 8px;border-bottom: 1px solid #ddd">
										<div class="col-md-10 col-xs-10 bold">TOTAL</div>
										<div class="col-md-2 col-xs-2 text-left bold">
											<p ng-class="{'error' : (totalPonderado!=limitPonderado)}">
												{{totalPonderado}}% 
											</p>
										</div>
									</div>
								</div><!-- panel-body -->
							</div>	<!-- panel-default -->
							<br>
							<!-- EJECUTIVO BCI aldo barbera -->
							
							<!-- footer -->
							<div>
								<div class="panel-footer text-right">
									<button class="btn btn-success" ng-click="registrarObjetivos();" ng-disabled="deshabilita">
										<i class="fa fa-pencil"></i> 
										Guardar
									</button>
									<button class="btn btn-default" ng-class="{'btn-primary':objetivosAdd.$valid && ponderadoValido}" ng-disabled="!objetivosAdd.$valid || !ponderadoValido" confirmed-click="enviarObjetivos()" ng-hide="nodoInicial"
									ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Enviar 
										<i class="fa fa-chevron-right"></i>
									</button>
									<button ng-show="nodoInicial" class="btn btn-default" ng-class="{'btn-primary':objetivosAdd.$valid && ponderadoValido}" ng-disabled="!objetivosAdd.$valid || !ponderadoValido" confirmed-click="agendarReunion()" ng-confirm-click="¿Deseas continuar? No podrás realizar cambios posteriores en esta etapa.">
										Agendar reunión
										<i class="fa fa-chevron-right"></i>
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
						
						<a href="<?php echo Router::url('/evaluaciones_objetivos', true); ?>" class="btn btn-default btn-md center">
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
	'angularjs/servicios/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/controladores/evaluaciones_objetivos/evaluaciones_objetivos',
	'angularjs/directivas/number_format',
	'bootstrap-datepicker',
	'angularjs/directivas/confirmacion'
	));
?>
