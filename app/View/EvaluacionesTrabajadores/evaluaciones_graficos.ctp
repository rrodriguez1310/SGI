<div ng-controller="evaluacionesGraficos" ng-cloak ng-init="buscarDatos('<?php echo date("Y");?>')">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="showFecha">
		<div class="row">
			<form class="form-horizontal" name="fecha" novalidate>
				<div class="col-sm-12 text-center">
					<label class="control-label text-right col-md-5 col-sm-12" >Año evaluación</label>
					<div class="col-md-7 col-sm-12">
						<ui-select ng-model="list.anioEvaluacion" name="AnioEvaluacion" style="width:220px">
							<ui-select-match placeholder=" -- Seleccione -- ">
								 <span>{{$select.selected.anio_evaluado}}</span>
							</ui-select-match>
							<ui-select-choices repeat="evaluacion.anio_evaluado as evaluacion in evaluacionesAnios | filter: $select.search">
								<div ng-bind-html="evaluacion.anio_evaluado | highlight: $select.search"></div>
							</ui-select-choices>
						</ui-select>
					</div>
				</div>
			</form>
		</div>
	</div><br>
	<div ng-if="ShowContenido">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div id="secciones">
					<ul class="nav nav-tabs">
						<li role="presentation" class="active" id="nav1"><a href="" ng-click="mostrarSeccion(1)">Participación</a></li>
						<li role="presentation" id="nav2"><a href="" ng-click="mostrarSeccion(2)">Familia Cargos</a></li>
						<li role="presentation" id="nav3"><a href="" ng-click="mostrarSeccion(3)">Situación Desempeño</a></li>
						<li role="presentation" id="nav4"><a href="" ng-click="mostrarSeccion(4)">Situación Desempeño (Competencias)</a></li>
						<li role="presentation" id="nav5"><a href="" ng-click="mostrarSeccion(5)">Comparativo Desempeño</a></li>
						<li role="presentation" id="nav6"><a href="" ng-click="mostrarSeccion(6)">Desempeño Gerencias</a></li>
						<li role="presentation" id="nav7"><a href="" ng-click="mostrarSeccion(7)">Desempeño NR</a></li>
						<li role="presentation" id="nav8"><a href="" ng-click="mostrarSeccion(8)">Desempeño NR (Competencias)</a></li>
						<li role="presentation" id="nav9"><a href="" ng-click="mostrarSeccion(9)">Desempeño NR / Familia Cargos</a></li>
					</ul>
				</div>
			</div>
		</div>
		<br />
		<div ng-if="seccionCumplimiento">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart1" config="chart1"></highchart>
		        </div>
			</div><br>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success"><b>Situación Desempeño</b></td>
							<td class="text-center success"><b>Promedio Competencias</b></td>
						</tr>
						<tr>
							<td class="text-center"><b>{{tabla1.desempeno}}</b></td>
							<td class="text-center"><b>{{tabla1.competencias}}</b></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionDistribucion">
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart2" config="chart2"></highchart>
		        </div>
			</div>			
		</div>
		<div ng-if="seccionDistribucionDesempeno">
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart3" config="chart3"></highchart>
		        </div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success"><b>Situación Desempeño</b></td>
							<td ng-repeat="desempeno in tabla3" class="text-center">
								<b>{{desempeno.nombre}}</b>
							</td>
						</tr>
						<tr>
							<td class="text-center success"><b>N° Colaboradores</b></td>
							<td ng-repeat="desempeno in tabla3" class="text-center">
								<b>{{desempeno.desempeno}}</b>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionDistribucionCompetencias">
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart4" config="chart4"></highchart>
		        </div>
			</div>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success"><b>Situación Desempeño</b></td>
							<td ng-repeat="desempeno in tabla4" class="text-center">
								<b>{{desempeno.nombre}}</b>
							</td>
						</tr>
						<tr>
							<td class="text-center success"><b>N° Colaboradores</b></td>
							<td ng-repeat="desempeno in tabla4" class="text-center">
								<b>{{desempeno.desem_compentencia}}</b>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionComparativo">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
		            <highchart id="chart5" config="chart5"></highchart>
		        </div>
			</div>			
		</div>
		<div ng-if="seccionComparativoGerencias">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
		            <highchart id="chart6" config="chart6"></highchart>
		        </div>
			</div><br>
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<table class="table table-striped table-bordered" style="font-size: 12px">						
						<tr>
							<td class="text-center success col-md-2"><b>Puntaje Ponderado</b></td>
							<td ng-repeat="desempeno in tablaBonos.PuntajePonderado" class="text-center">
								{{desempeno.rango_inicio}} - {{desempeno.rango_termino}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2"><b>Situación Desempeño</b></td>
							<td ng-repeat="desempeno in tablaBonos.PuntajePonderado" class="text-center">
								{{desempeno.nombre}}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionDistribucionNivel">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
		            <highchart id="chart7" config="chart7"></highchart>
		        </div>
			</div><br>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success col-md-2"><b>NR</b></td>
							<td ng-repeat="nivel in tablaDatos7.nivelesR" class="text-center">
								{{nivel}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2"><b>Familia Cargos</b></td>
							<td ng-repeat="nombre in tablaDatos7.nombres" class="text-center" colspan="{{tablaDatos7.grupos[$index]}}">
								{{nombre}}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionDistNivelCompetencias">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
		            <highchart id="chart8" config="chart8"></highchart>
		        </div>
			</div><br>
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success col-md-2"><b>NR</b></td>
							<td ng-repeat="nivel in tablaDatos7.nivelesR" class="text-center">
								{{nivel}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2"><b>Familia Cargos</b></td>
							<td ng-repeat="nombre in tablaDatos7.nombres" class="text-center" colspan="{{tablaDatos7.grupos[$index]}}">
								{{nombre}}
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<div ng-if="seccionDistNivelFamlia">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
		            <highchart id="chart9" config="chart9"></highchart>
		        </div>
			</div><br>
			<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success col-md-2"><b>NR</b></td>
							<td ng-repeat="nivel in tablaDatos7.nivelesR" class="text-center">
								{{nivel}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2"><b>Familia Cargos</b></td>
							<td ng-repeat="nombre in tablaDatos7.nombres" class="text-center" colspan="{{tablaDatos7.grupos[$index]}}">
								{{nombre}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2 text-info"><b>Situación Desempeño</b></td>
							<td ng-repeat="situaciones in tablaDatos9.situacion track by $index" class="text-center text-info">
								{{situaciones}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2 text-danger"><b>Competencias</b></td>
							<td ng-repeat="competencias in tablaDatos9.competencia track by $index" class="text-center text-danger">
								{{competencias}}
							</td>
						</tr>
						<tr>
							<td class="text-center success col-md-2"><b>N° Ocupantes</b></td>
							<td ng-repeat="ocupantes in tablaDatos9.participantes track by $index" class="text-center">
								{{ocupantes}}
							</td>
						</tr>
					</table>
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
	'bootstrap-datepicker',
	'highcharts-grouped-categories.min',

	'angularjs/controladores/evaluaciones_trabajadores/listar_evaluaciones',
	"angularjs/servicios/evaluaciones_trabajadores/evaluaciones"
	
));
?>