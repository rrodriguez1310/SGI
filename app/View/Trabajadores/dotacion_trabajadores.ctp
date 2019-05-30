<div ng-controller="trabajadoresDotacionTrabajadores" ng-cloak ng-init="fecha('<?php echo date("d/m/Y");?>')">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="showFecha">
		<div class="row">
			<form class="form-horizontal">
			<div class="form-group">
				<label class="col-md-6 control-label baja">Fecha busqueda</label>
				<div class="col-md-3">
					<div class="input">  
						<input type="text" ng-model="fechaBusqueda" ng-change="buscarDatos(fechaBusqueda)" name="Fecha_Documento" class="form-control readonly-pointer-background datepicker" placeholder = 'Seleccione fecha inicial' readonly="readonly" required/>
					</div>			      	
				</div>	
			</div>
		</div>
	</div>
	<div ng-if="ShowContenido">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div id="secciones">
					<ul class="nav nav-tabs">
						<li role="presentation" class="active" id="nav1"><a href="" ng-click="mostrarSeccion(1)">Dotación</a></li>
						<li role="presentation" id="nav2"><a href="" ng-click="mostrarSeccion(2)">Antigüedad</a></li>
						<li role="presentation" id="nav3"><a href="" ng-click="mostrarSeccion(3)">Dotación Gerencias</a></li>
						<li role="presentation" id="nav4"><a href="" ng-click="mostrarSeccion(4)">Rango edades</a></li>
						<li role="presentation" id="nav5"><a href="" ng-click="mostrarSeccion(5)">Estado civil</a></li>
						<li role="presentation" id="nav6"><a href="" ng-click="mostrarSeccion(6)">Desvinculaciones</a></li>
					</ul>	
				</div>
			</div>
		</div>
		<br />
		<div ng-if="seccionDotacion">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="4">
									<small><a class="btn btn-default pull-right" ng-click="verPersonasDotacion()"><i class="fa fa-users"></i></a></small>
									<h4>
										Dotación Trabajadores a {{ fecha | date : "dd/MM/yyyy" }}
									</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Tipo de Contrato</th>
								<th class="text-center">Hombres</th>
								<th class="text-center">Mujeres</th>
								<th class="text-center">Total</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(tipoContrato, dotacion) in dotaciones" ng-if="tipoContrato != 'total_general'">
								<td class="text-center">{{tipoContratos[tipoContrato] | uppercase }}</td>
								<td class="text-center">{{ dotacion[0].total_sexo | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{ dotacion[1].total_sexo | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{ dotacion.total_tipo_contrato }}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center">{{dotaciones.total_general[0] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{dotaciones.total_general[1] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{dotaciones.total_general.total}}</td>
							</tr>
							<tr class="warning">
								<td class="text-center">%</td>
								<td class="text-center">{{dotaciones.total_general.porcentaje[0] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{dotaciones.total_general.porcentaje[1] | undefinedPorValor : "0"}}</td>
								<td class="text-center">100</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart1" config="chart"></highchart>
		        </div>
			</div>
		</div>
		<div ng-if="seccionAntiguedad">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="5">
									<small><a class="btn btn-default pull-right" ng-click="verPersonasAntiguedad()" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-users"></i></a></small>
									<h4>Antigüedad Dotación a {{ fecha | date : "dd/MM/yyyy" }}</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Años</th>
								<th class="text-center">Hombres</th>
								<th class="text-center">Mujeres</th>
								<th class="text-center">Total</th>
								<th class="text-center">%</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(anio, antiguedad) in antiguedades.anios | orderBy : antiguedad.anio" ng-switch on="anio">
								<td ng-switch-when="7" class="text-center">más de {{ anio }}</td>
								<td ng-switch-default class="text-center">{{ anio }}-{{(anio | parseInt) +1}} años</td>
								<td class="text-center">{{ antiguedad[0] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{ antiguedad[1] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{ antiguedad.total }}</td>
								<td class="text-center">{{ antiguedad.porcentaje }}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center">{{antiguedades.totales[0] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{antiguedades.totales[1] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{antiguedades.totales.total}}</td>
								<td class="text-center">100</td>
							</tr>
							<tr class="warning">
								<td class="text-center">Antigüedad prom (años)</td>
								<td class="text-center">{{antiguedades.antiguedadPro[0] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{antiguedades.antiguedadPro[1] | undefinedPorValor : "0"}}</td>
								<td class="text-center">{{antiguedades.antiguedadPro.total}}</td>
								<td class="text-center"></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart2" config="chart2"></highchart>
		        </div>
			</div>			
		</div>
		<div ng-if="seccionGerencias">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<div class="panel panel-default" ng-repeat="(gerencia, areas) in dotacionPorGerencias.gerencias">
							<div class="panel-heading" role="tab" id="headingOne">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse{{$index}}">
										{{gerencia | uppercase }}
									</a>
								</h4>
							</div>
							<div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
								<div class="panel-body">
									<div class="row">
										<div class="col-md-12">
											<table class="table table-striped table-bordered">
												<thead>
													<tr>
														<th colspan="{{dotacionPorGerencias.anios.length+1}}" class="text-center">{{gerencia | uppercase}}</th>
													</tr>
													<tr>
														<th class="text-center">Área</th>
														<th ng-repeat="(key, anio) in dotacionPorGerencias.anios" class="text-center">{{anio}}</th>
													</tr>
												</thead>
												<tbody>
													<tr ng-repeat="(key, area) in areas | sortArray">
														<td class="text-center">{{area | uppercase}}</td>
														<td ng-repeat="(key, anio) in dotacionPorGerencias.anios" class="text-center">{{dotacionPorGerencias.data[gerencia][area][anio] | undefinedPorValor : "0"}}</td>
													</tr>
													<tr class="success">
														<td class="text-center">Total</td>
														<td ng-repeat="(key, anio) in dotacionPorGerencias.anios" class="text-center">{{dotacionPorGerencias.totales[gerencia][anio] | undefinedPorValor : "0"}}</td>
													</tr>
												</tbody>
											</table>		
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart3" config="chart3"></highchart>
		        </div>
			</div>
		</div>
		<div ng-if="seccionEdades">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="5">
									<h4>Rango edades a {{ fecha | date : "dd/MM/yyyy" }}</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Rango</th>
								<th class="text-center">Trabajadores</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="text-center">< 25 años</td>
								<td class="text-center">{{rangoEdades[0] | undefinedPorValor : "0" }}</td>
							</tr>
							<tr>
								<td class="text-center">25 < 35 años</td>
								<td class="text-center">{{rangoEdades[25] | undefinedPorValor : "0"}}</td>
							</tr>
							<tr>
								<td class="text-center">35 < 45 años</td>
								<td class="text-center">{{rangoEdades[35] | undefinedPorValor : "0"}}</td>
							</tr>
							<tr>
								<td class="text-center">45 años < </td>
								<td class="text-center">{{rangoEdades[45] | undefinedPorValor : "0"}}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center">{{rangoEdades.total | undefinedPorValor : "0"}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart4" config="chart4"></highchart>
		        </div>
			</div>
		</div>
		<div ng-if="seccionEstadosCiviles">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="5">
									<h4>Estado Civil a {{ fecha | date : "dd/MM/yyyy" }}</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Estado Civil</th>
								<th class="text-center">Trabajadores</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="(id, estadoCivil) in estadosCiviles.estadosCiviles | orderBy :'nombre'">
								<td class="text-center">{{ estadoCivil.nombre | uppercase }}</td>
								<td class="text-center">{{ estadosCiviles.data[estadoCivil.id] | undefinedPorValor : "0" }}</td>
							</tr>
							<tr ng-if="estadosCiviles.noDefinidos">
								<td class="text-center">NO DEFINIDOS</td>
								<td class="text-center">{{ estadosCiviles.noDefinidos }}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center">{{estadosCiviles.data.total}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart5" config="chart5"></highchart>
		        </div>
			</div>
		</div>
		<div ng-if="seccionDesvinculaciones">
			<div class="row">
				<div class="col-md-10 col-md-offset-1 text-center">
					<div class="btn-group">
						<button type="button" class="btn btn-primary" ng-click="desvinculacionTipo(1)" ng-class="{'active' : toggleAnio}">Años</button>
						<button type="button" class="btn btn-default" ng-click="desvinculacionTipo(2)" ng-class="{'active' : toggleMeses}">Meses</button>
					</div>
				</div>
			</div>
			<br />
			<div ng-if="desAnuales">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="text-center" colspan="5">
										<h4>Desvinculaciones anuales a {{ fecha | date : "dd/MM/yyyy" }}</h4>
									</th>
								</tr>
								<tr>
									<th class="text-center">Año</th>
									<th class="text-center">Desvinculaciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="anio in desvinculaciones.anios">
									<td class="text-center">{{ anio }}</td>
									<td class="text-center">{{ desvinculaciones.data.total.anios[anio] | undefinedPorValor : "0" }}</td>
								</tr>
								<tr class="success">
									<td class="text-center">Total</td>
									<td class="text-center">{{desvinculaciones.data.total.general | undefinedPorValor : "0" }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
			            <highchart id="chart6" config="chart6"></highchart>
			        </div>
				</div>
			</div>
			<div ng-if="desMeses">
				<div class="row">
					<div class="col-md-6 col-md-offset-3 text-center">
						<form class="form-horizontal">
							<div class="form-group">
								<label class="control-label text-right baja_sin_form col-md-4">Año</label>
								<div class="col-md-6">
									<select class="form-control" ng-model="anioDesvinculacion" ng-change="cambioAnio(anioDesvinculacion)" ng-options="anios for anios in desvinculaciones.anios | orderBy : anios : true">
									</select>	
								</div>
							</div>
						</form>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="text-center" colspan="5">
										<h4>Desvinculaciones año {{ anioDesvinculacion }}</h4>
										<small>Desvinculaciones anuales hasta {{ tituloDesvinculacion | date : "dd/MM/yyyy" }}</small>
									</th>
								</tr>
								<tr>
									<th class="text-center">Meses</th>
									<th class="text-center">Desvinculaciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="mes in desvinculaciones.meses | orderBy : 'mes'">
									<td class="text-center">{{ mes.nombre | capitalize }}</td>
									<td class="text-center">{{ desvinculaciones.data.meses[anioDesvinculacion][mes.mes] | undefinedPorValor : "0" }}</td>
								</tr>
								<tr class="success">
									<td class="text-center">Total</td>
									<td class="text-center">{{desvinculaciones.data.meses[anioDesvinculacion].total | undefinedPorValor : "0"}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
			            <highchart id="chart7" config="chart7"></highchart>
			        </div>
				</div>
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="text-center" colspan="5">
										<h4>Motivos desvinculaciones año {{ anioDesvinculacion }}</h4>
										<small>Motivos desvinculaciones hasta {{ tituloDesvinculacion | date : "dd/MM/yyyy" }}</small>
									</th>
								</tr>
								<tr>
									<th class="text-center">Motivo</th>
									<th class="text-center">Desvinculaciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="motivo in serie8 | orderBy : 'name'">
									<td class="text-center">{{ motivo.name | capitalize }}</td>
									<td class="text-center">{{ motivo.y | undefinedPorValor : "0" }}</td>
								</tr>
								<tr class="success">
									<td class="text-center">Total</td>
									<td class="text-center">{{ totalDesvinculaciones | undefinedPorValor : "0"}}</td-->
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
			            <highchart id="chart8" config="chart8"></highchart>
			        </div>
				</div>
			</div>
		</div>
	</div>
	<modal visible="showModal">
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-exporter class="grid" ui-grid-resize-columns ui-grid-auto-resize></div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col-md-12 text-center">
	        		<button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal"><i class="fa fa-reply-all"></i> Cerrar</button>		
				</div>
			</div>
	    </div>
	</modal>
	<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{ titulo }}</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>
								</div>
								<div class="panel-body" ng-init="isDisabled = true">
									<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div ui-grid="gridOptions" ui-grid-exporter class="grid" ui-grid-resize-columns ui-grid-auto-resize></div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-12 text-center">
				        		<button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal"><i class="fa fa-reply-all"></i> Cerrar</button>		
							</div>
						</div>
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/directivas/modal/modal",
	"angularjs/filtros/filtros",
	"angularjs/servicios/trabajadores",
	"angularjs/servicios/servicios",
	"angularjs/controladores/trabajadores",
	'bootstrap-datepicker'
));
?>