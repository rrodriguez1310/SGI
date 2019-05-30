<div ng-controller="mainRatingMinutos" ng-cloak>
	<div ng-controller="bandas">
		<div class="col-md-12">
			<div class="row">
				<form class="form-horizontal" name="formBandas" novalidate>
					<div class="form-group">
						<label for="fecha" class="control-label baja col-md-2 col-md-offset-3">Fecha</label>
						<div class="input text col-md-2">
							<input type="text" class="form-control fecha readonly-pointer-background" readonly placeholder="Seleccione fecha" name="fecha" ng-model="fecha" required>							
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<button class="btn btn-primary col-md-offset-5 col-md-2" ng-disabled="!formBandas.$valid || buscando" ng-click="buscar_bandas()"><i class="fa fa-search"></i> Buscar</button>	
						</div>
					</div>
				</form>
			</div>
			<br/>
			<p ng-bind-html="cargador" ng-show="loader"></p>
			<div ng-if="tablas">
				<div class="row">
					<div class="col-md-12">
						<h4 style="border-bottom: thin solid">Acumulados mensual y anual {{ maxDiaData | date : 'dd/MM/yyyy'}}</h4>
					</div>	
				</div>
				<div class="row">
					<ul class="nav nav-tabs nav-justified">
						<li role="presentation" class="active acumulados" id="acumuladoRating"><a href ng-click="acumuladoRating()">Rating</a></li>
						<li role="presentation" class="acumulados" id="acumuladoShare"><a href ng-click="acumuladoShare()">Share</a></li>
					</ul>
				</div>
				<div ng-hide="acumuladoRatingShow">
					<div class="row">
						<div class="col-md-7">
							<br />
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating</th>
										<th colspan="2" class="text-center">MTD</th>
										<th colspan="2" class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th colspan="2" class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th colspan="2" class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Año</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(tipo, valores) in anioAcumulado[1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
										<td ng-switch-when="1">CDF's</td>
										<td ng-switch-when="2">FOX's</td>
										<td ng-switch-when="3">ESPN's</td> 
										<td ng-switch-when="5">OTROS</td>
										<td>{{ mesAcumulado[1][tipo]["rating"] | number : 3 }}</td>
										<td>{{ mesAnteriorAcumulado[1][tipo]["rating"] | number : 3}}</td>
										<td>{{ valores.rating | number : 3}}</td>
										<td>{{ anioAnteriorAcumulado[1][tipo]["rating"] | number : 3}}</td>
									</tr>
									<tr>
										<td>TVR DEP.</td>
										<td>{{ mesAcumulado[1][1]["tvr"] | number : 3 }}</td>
										<td>{{ mesAnteriorAcumulado[1][1]["tvr"] | number : 3 }}</td>
										<td>{{ anioAcumulado[1][1]["tvr"] | number : 3 }}</td>
										<td>{{ anioAnteriorAcumulado[1][1]["tvr"] | number : 3 }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<br />
						<div class="col-md-5">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating Var</th>
										<th class="text-center">MTD</th>
										<th class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Años</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(tipo, valores) in anioAcumulado[1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
										<td ng-switch-when="1">CDF's</td>
										<td ng-switch-when="2">FOX's</td>
										<td ng-switch-when="3">ESPN's</td>
										<td ng-switch-when="5">OTROS</td>
										<td>{{ ((mesAcumulado[1][tipo]["rating"]-mesAnteriorAcumulado[1][tipo]["rating"])/mesAnteriorAcumulado[1][tipo]["rating"])*100 | number : 0 }} %</td>
										<td>{{ ((valores.rating-anioAnteriorAcumulado[1][tipo]["rating"])/anioAnteriorAcumulado[1][tipo]["rating"])*100 | number : 0}} %</td>
									</tr>
									<tr>
										<td>TVR DEP.</td>
										<td>{{ ((mesAcumulado[1][1]["tvr"]-mesAnteriorAcumulado[1][1]["tvr"])/mesAnteriorAcumulado[1][1]["tvr"])*100 | number : 0 }} %</td>
										<td>{{ ((anioAcumulado[1][1]["tvr"]-anioAnteriorAcumulado[1][1]["tvr"])/anioAnteriorAcumulado[1][1]["tvr"])*100 | number : 0 }} %</td>
									</tr>
								</tbody>
							</table>	
						</div>					
					</div>
					<div class="row">
						<div class="col-md-7">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating</th>
										<th colspan="2" class="text-center">MTD</th>
										<th colspan="2" class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th colspan="2" class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th colspan="2" class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Año</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(canalId, valores) in dataSemana[3]['data']['mtd'][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
										<td>{{ valores.nombre_corto | uppercase }}</td>
										<td>{{ !!valores.rating ? valores.rating : 0 | number : 3 }}</td>
										<td>{{ !!dataSemana[4]['data']['mtd'][1][valores.canal_id] ? dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"] : 0 | number : 3 }}</td>
										<td>{{ !!dataSemana[3]['data']['ytd'][1][valores.canal_id] ? dataSemana[3]['data']['ytd'][1][valores.canal_id]["rating"] : 0 | number : 3 }}</td>
										<td>{{ !!dataSemana[4]['data']['ytd'][1][valores.canal_id] ? dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"] : 0 | number : 3 }}</td>
									</tr>
									<tr>
										<td>TVR DEP.</td>
										<td>{{ dataSemana[3]['data']['mtd'][1][1]["tvr"] | number : 3 }}</td>
										<td>{{ dataSemana[4]['data']['mtd'][1][1]["tvr"] | number : 3 }}</td>
										<td>{{ dataSemana[3]['data']['ytd'][1][1]["tvr"] | number : 3 }}</td>
										<td>{{ dataSemana[4]['data']['ytd'][1][1]["tvr"] | number : 3 }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						
						<div class="col-md-5">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating Var</th>
										<th class="text-center">MTD</th>
										<th class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Años</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(canalId, valores) in dataSemana[3]['data']['mtd'][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
										<td> {{ valores.nombre_corto | uppercase }}</td>
										<td>{{ (!!dataSemana[4]['data']['mtd'][1][valores.canal_id] && dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"]!=0) ? ((valores.rating-dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"])/dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"])*100 : 0 | number : 0 }} %</td>
										<td>{{ (!!dataSemana[3]['data']['ytd'][1][valores.canal_id] && !!dataSemana[4]['data']['ytd'][1][valores.canal_id] && dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"]!=0) ? ((dataSemana[3]['data']['ytd'][1][valores.canal_id]["rating"]-dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"])/dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"])*100 : 0 | number : 0 }} %</td>
									</tr>
									<tr>
										<td> TVR DEP.</td>
										<td>{{ ((dataSemana[3]['data']['mtd'][1][1]["tvr"]-dataSemana[4]['data']['mtd'][1][1]["tvr"])/dataSemana[4]['data']['mtd'][1][1]["tvr"])*100 | number : 0 }} %</td>
										<td>{{ ((dataSemana[3]['data']['ytd'][1][1]["tvr"]-dataSemana[4]['data']['ytd'][1][1]["tvr"])/dataSemana[4]['data']['ytd'][1][1]["tvr"])*100 | number : 0 }} %</td>
									</tr>
								</tbody>
							</table>
						</div>								
					</div>
					<div class="row">
						<div class="col-md-12">
				            <highchart id="chart1" config="chartRating"></highchart>
				        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
				            <highchart id="chart2" config="chartRating2"></highchart>
				        </div>
					</div>
				</div>	
				<div ng-show="acumuladoShareShow">
					<div class="row">
						<div class="col-md-7">
							<br />
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Share</th>
										<th colspan="2" class="text-center">MTD</th>
										<th colspan="2" class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th colspan="2" class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th colspan="2" class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Año</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(tipo, valores) in anioAcumulado[1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
										<td ng-switch-when="1">CDF's</td>
										<td ng-switch-when="2">FOX's</td>
										<td ng-switch-when="3">ESPN's</td>
										<td ng-switch-when="5">OTROS</td>
										<td>{{ (mesAcumulado[1][tipo]["rating"]/mesAcumulado[1][1]["tvr"])*100 | number : 1 }} %</td>
										<td>{{ mesAnteriorAcumulado[1][1]["tvr"]!=0 ? (mesAnteriorAcumulado[1][tipo]["rating"]/mesAnteriorAcumulado[1][1]["tvr"])*100 : 0 | number : 1 }} %</td>
										<td>{{ anioAcumulado[1][1]["tvr"]!=0 ? (valores.rating/anioAcumulado[1][1]["tvr"])*100 : 0 | number : 1 }} %</td>
										<td>{{ anioAnteriorAcumulado[1][1]["tvr"]!=0 ? (anioAnteriorAcumulado[1][tipo]["rating"]/anioAnteriorAcumulado[1][1]["tvr"])*100 : 0 | number : 1 }} %</td>
									</tr>
								</tbody>
							</table>
						</div>
						<br />
						<div class="col-md-5">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating Var</th>
										<th class="text-center">MTD</th>
										<th class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Años</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(tipo, valores) in anioAcumulado[1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
										<td ng-switch-when="1">CDF's</td>
										<td ng-switch-when="2">FOX's</td>
										<td ng-switch-when="3">ESPN's</td>
										<td ng-switch-when="5">OTROS</td>
										<td>{{ (((mesAcumulado[1][tipo]["rating"]/mesAcumulado[1][1]["tvr"])-(mesAnteriorAcumulado[1][tipo]["rating"]/mesAnteriorAcumulado[1][1]["tvr"]))/(mesAnteriorAcumulado[1][tipo]["rating"]/mesAnteriorAcumulado[1][1]["tvr"]))*100 | number : 0 }} %</td>
										<td>{{ (((valores.rating/anioAcumulado[1][1]["tvr"])-(anioAnteriorAcumulado[1][tipo]["rating"]/anioAnteriorAcumulado[1][1]["tvr"]))/(anioAnteriorAcumulado[1][tipo]["rating"]/anioAnteriorAcumulado[1][1]["tvr"]))*100 | number : 0}} %</td>
									</tr>
								</tbody>
							</table>	
						</div>						
					</div>
					<div class="row">
						<div class="col-md-7">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<thead>
									<tr>
										<th class="text-center">Share</th>
										<th colspan="2" class="text-center">MTD</th>
										<th colspan="2" class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th colspan="2" class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th colspan="2" class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Año</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }}</th>
										<th class="text-center">{{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								</thead>
								<tbody>
									<tr ng-repeat="(canalId, valores) in dataSemana[3]['data']['mtd'][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
										<td>{{ valores.nombre_corto | uppercase }}</td>
										<td>{{ valores.tvr>0 ? (valores.rating/valores.tvr)*100 : 0 | number : 1 }} %</td>
										<td>{{ dataSemana[4]['data']['mtd'][1][valores.canal_id]["tvr"]>0 ? (dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['mtd'][1][valores.canal_id]["tvr"])*100 : 0 | number : 1 }} %</td>
										<td>{{ dataSemana[3]['data']['ytd'][1][valores.canal_id]["tvr"]>0 ? (dataSemana[3]['data']['ytd'][1][valores.canal_id]["rating"]/dataSemana[3]['data']['ytd'][1][valores.canal_id]["tvr"])*100 : 0 | number : 1 }} %</td>
										<td>{{ dataSemana[4]['data']['ytd'][1][valores.canal_id]["tvr"]>0 ? (dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['ytd'][1][valores.canal_id]["tvr"])*100 : 0 | number : 1 }} %</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-5">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th class="text-center">Rating Var</th>
										<th class="text-center">MTD</th>
										<th class="text-center">YTD</th>
									</tr>
									<tr>
										<th class="text-center">Periodo</th>
										<th class="text-center">{{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
										<th class="text-center">ENERO - {{ (maxDiaData | date : 'MMMM') | uppercase }}</th>
									</tr>
									<tr>
										<th class="text-center">Años</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
										<th class="text-center">{{ semana10.informacion.anio }} vs {{ semana12.informacion.anio }}</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(canalId, valores) in dataSemana[3]['data']['mtd'][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
										<td>{{ valores.nombre_corto | uppercase }}</td>
										<td>{{ valores.tvr>0 && dataSemana[4]['data']['mtd'][1][valores.canal_id]["tvr"]>0 && dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"]>0 ? (((valores.rating/valores.tvr)-(dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['mtd'][1][valores.canal_id]["tvr"]))/(dataSemana[4]['data']['mtd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['mtd'][1][valores.canal_id]["tvr"]))*100 : 0 | number : 0 }} %</td>
										<td>{{ dataSemana[3]['data']['ytd'][1][valores.canal_id]["tvr"]>0 && dataSemana[4]['data']['ytd'][1][valores.canal_id]["tvr"]>0 && dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"]>0? (((dataSemana[3]['data']['ytd'][1][valores.canal_id]["rating"]/dataSemana[3]['data']['ytd'][1][valores.canal_id]["tvr"])-(dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['ytd'][1][valores.canal_id]["tvr"]))/(dataSemana[4]['data']['ytd'][1][valores.canal_id]["rating"]/dataSemana[4]['data']['ytd'][1][valores.canal_id]["tvr"]))*100 : 0 | number : 0 }} %</td>
									</tr>
								</tbody>
							</table>
						</div>				
					</div>
					<div class="row">
						<div class="col-md-12">
				            <highchart id="chart3" config="chartShare"></highchart>
				        </div>
					</div>
					<div class="row">
						<div class="col-md-12">
				            <highchart id="chart4" config="chartShare2"></highchart>
				        </div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<h4 style="border-bottom: thin solid">Semanas</h4>
					</div>	
				</div>
				<div class="row">
					<ul class="nav nav-tabs bandas nav-justified">
						<li role="presentation" id="nav0" class="active"><a ng-click="nav(0)" href="javascript:void(0)">S. {{ semana10.informacion.semana }} {{ semana10.informacion.anio }}</a></li>
						<li role="presentation" id="nav1"><a ng-click="nav(1)" href="javascript:void(0)">S. {{ semana11.informacion.semana }} {{ semana11.informacion.anio }}</a></li>
						<li role="presentation" id="nav2"><a ng-click="nav(2)" href="javascript:void(0)">S. {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</a></li>
						<li role="presentation" id="nav3"><a ng-click="nav(3)" href="javascript:void(0)">S. {{ semana10.informacion.semana }} {{ semana10.informacion.anio }} v/s {{ semana11.informacion.semana }} {{ semana11.informacion.anio }}</a></li>
						<li role="presentation" id="nav4"><a ng-click="nav(4)" href="javascript:void(0)">S. {{ semana10.informacion.semana }} {{ semana10.informacion.anio }} v/s {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</a></li>
					</ul>
				</div>
				<br/>
				<div ng-show="navs0">
					<div ng-show="tabs0">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Acumulado Semanal</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ semanaAcumulada[1][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
									</tbody>
								</table>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][0][1][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ dataSemana[6]['data'][0][1][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][0][1][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>							
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Bandas Horarias</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center" role="toolbar" aria-label="...">
									<div class="btn-group botonera0" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn0 active" id="1" ng-click="diaSemana(0,0)">Lunes</button>
										<button type="button" class="btn btn-default btn1" id="2" ng-click="diaSemana(0,1)">Martes</button>
										<button type="button" class="btn btn-default btn2" id="3" ng-click="diaSemana(0,2)">Miercoles</button>
										<button type="button" class="btn btn-default btn3" id="4" ng-click="diaSemana(0,3)">Jueves</button>
										<button type="button" class="btn btn-default btn4" id="5" ng-click="diaSemana(0,4)">Viernes</button>
										<button type="button" class="btn btn-default btn5" id="6" ng-click="diaSemana(0,5)">Sabado</button>
										<button type="button" class="btn btn-default btn6" id="7" ng-click="diaSemana(0,6)">Domingo</button>
									</div>
									<div class="btn-group botonera0" role="group" aria-label="...">
										<button type="button" class="btn btn-default semana0" id="15" ng-click="semana(0)">Semana</button>
										<button type="button" class="btn btn-default lav0" id="16" ng-click="lav(0)">L - V</button>
										<button type="button" class="btn btn-default sad0" id="17" ng-click="sad(0)">S - D</button>
									</div>
								</div>
							</div>
						</div>
						<br/>
					</div>
					<div ng-show="tablaSemana0">
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">RATING</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="vertical-align: middle">
											<h5>Semana {{ semana10.informacion.semana }} {{ semana10.informacion.anio }}</h5>
											<small>{{ semana10.informacion.fechaInicio }} a {{ semana10.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
										<th rowspan="2" class="text-center">TVR<br/><small>Encendido</small></th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana10" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key| parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana20">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana10.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfb/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfp/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfhd/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espnm/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn2/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn3/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espnhd/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs2/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs3/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fsp/semana10.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.tvr/semana10.informacion.promedio) | number : 3) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">SHARE %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="vertical-align: middle">
											<h5>Semana {{ semana10.informacion.semana }} {{ semana10.informacion.anio }}</h5>
											<small>{{ semana10.informacion.fechaInicio }} a {{ semana10.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana10" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key| parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana20">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfb/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfp/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.cdfhd/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espnm/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn2/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espn3/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.espnhd/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs2/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fs3/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana10.promedio.fsp/semana10.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" ng-show="errorTablaSemana0">
						<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>{{ error0 }}</strong></div>
					</div>
				</div>
				<div ng-show="navs1">
					<div ng-show="tabs1">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Acumulado Semanal</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana11.informacion.semana }} {{ semanaAcumulada[0][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[0][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[0][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[0][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ semanaAcumulada[0][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana11.informacion.semana }} {{ semanaAcumulada[0][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[0][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[0][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[0][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
									</tbody>
								</table>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana11.informacion.semana }} {{ semanaAcumulada[0][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[0][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[0][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][0][0][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ dataSemana[6]['data'][0][0][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana11.informacion.semana }} {{ semanaAcumulada[0][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[0][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[0][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][0][0][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>							
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Bandas Horarias</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center" role="toolbar" aria-label="...">
									<div class="btn-group botonera1" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn0 active" id="8" ng-click="diaSemana(1,0)">Lunes</button>
										<button type="button" class="btn btn-default btn1" id="9" ng-click="diaSemana(1,1)">Martes</button>
										<button type="button" class="btn btn-default btn2" id="10" ng-click="diaSemana(1,2)">Miercoles</button>
										<button type="button" class="btn btn-default btn3" id="11" ng-click="diaSemana(1,3)">Jueves</button>
										<button type="button" class="btn btn-default btn4" id="12" ng-click="diaSemana(1,4)">Viernes</button>
										<button type="button" class="btn btn-default btn5" id="13" ng-click="diaSemana(1,5)">Sabado</button>
										<button type="button" class="btn btn-default btn6" id="14" ng-click="diaSemana(1,6)">Domingo</button>
									</div>
									<div class="btn-group botonera1" role="group" aria-label="...">
										<button type="button" class="btn btn-default semana1" id="18" ng-click="semana(1)">Semana</button>
										<button type="button" class="btn btn-default lav1" id="19" ng-click="lav(1)">L - V</button>
										<button type="button" class="btn btn-default sad1" id="20" ng-click="sad(1)">S - D</button>
									</div>
								</div>
							</div>
						</div>
						<br/>
					</div>
					<div ng-show="tablaSemana1">
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">RATING</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana11.informacion.semana }} {{ semana11.informacion.anio }}</h5>
											<small>{{ semana11.informacion.fechaInicio }} a {{ semana11.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
										<th rowspan="2" class="text-center">TVR<br/><small>Encendido</small></th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana11" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana21">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana11.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfb/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfp/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfhd/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espnm/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn2/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn3/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espnhd/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs2/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs3/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fsp/semana11.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.tvr/semana11.informacion.promedio) | number : 3) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">SHARE %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana11.informacion.semana }} {{ semana11.informacion.anio }}</h5>
											<small>{{ semana11.informacion.fechaInicio }} a {{ semana11.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana11" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key| parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana21">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfb/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfp/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.cdfhd/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espnm/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn2/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espn3/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.espnhd/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs2/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fs3/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana11.promedio.fsp/semana11.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" ng-show="errorTablaSemana1">
						<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>{{ error1 }}</strong></div>
					</div>
				</div>
				<div ng-show="navs2">
					<div ng-show="tabs2">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Acumulado Semanal</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAnteriorAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAnteriorAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ semanaAnteriorAcumulada[1][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAnteriorAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAnteriorAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>RATING</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAnteriorAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][1][1][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ valores.rating | number : 3 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ dataSemana[6]['data'][1][1][1][1]["tvr"] | number : 3 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAnteriorAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAnteriorAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(canalId, valores) in dataSemana[6]['data'][1][1][1] | ordenaXOtroArreglo:canalesOrder" ng-if="valores.canal_id != 14 && !!valores.nombre_corto">
											<td>{{ valores.nombre_corto | uppercase }}</td>
											<td>{{ (valores.rating/valores.tvr)*100 | number : 2 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>							
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Bandas Horarias</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center" role="toolbar" aria-label="...">
									<div class="btn-group botonera2" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn0 active" id="21" ng-click="diaSemana(2,0)">Lunes</button>
										<button type="button" class="btn btn-default btn1" id="22" ng-click="diaSemana(2,1)">Martes</button>
										<button type="button" class="btn btn-default btn2" id="23" ng-click="diaSemana(2,2)">Miercoles</button>
										<button type="button" class="btn btn-default btn3" id="24" ng-click="diaSemana(2,3)">Jueves</button>
										<button type="button" class="btn btn-default btn4" id="25" ng-click="diaSemana(2,4)">Viernes</button>
										<button type="button" class="btn btn-default btn5" id="26" ng-click="diaSemana(2,5)">Sabado</button>
										<button type="button" class="btn btn-default btn6" id="27" ng-click="diaSemana(2,6)">Domingo</button>
									</div>
									<div class="btn-group botonera2" role="group" aria-label="...">
										<button type="button" class="btn btn-default semana2" id="28" ng-click="semana(2)">Semana</button>
										<button type="button" class="btn btn-default lav2" id="28" ng-click="lav(2)">L - V</button>
										<button type="button" class="btn btn-default sad2" id="30" ng-click="sad(2)">S - D</button>
									</div>
								</div>
							</div>
						</div>
						<br/>
					</div>
					<div ng-show="tablaSemana2">
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">RATING</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</h5>
											<small>{{ semana12.informacion.fechaInicio }} a {{ semana12.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
										<th rowspan="2" class="text-center">TVR<br/><small>Encendido</small></th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana12" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana22">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfp/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnm/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn2/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espn3/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.espnhd/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs2/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fs3/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.fsp/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
										<td>{{ ((value.tvr/semana12.informacion.dividido) | number : 3) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfb/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfp/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfhd/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espnm/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn2/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn3/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espnhd/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs2/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs3/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fsp/semana12.informacion.promedio) | number : 3) }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.tvr/semana12.informacion.promedio) | number : 3) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">SHARE %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</h5>
											<small>{{ semana12.informacion.fechaInicio }} a {{ semana12.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana12" ng-if="key!='promedio' && key!='informacion'">
										<td>{{ key| parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana22">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td>{{ ((value.cdfb/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfp/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.cdfhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnm/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espn3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.espnhd/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs2/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fs3/value.tvr)*100 | number : 1) | ceroNada }}</td>
										<td>{{ ((value.fsp/value.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" class="warning" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfb/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfp/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.cdfhd/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espnm/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn2/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espn3/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.espnhd/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs2/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fs3/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
										<td class="warning" style="vertical-align: middle">{{ ((semana12.promedio.fsp/semana12.promedio.tvr)*100 | number : 1) | ceroNada }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" ng-show="errorTablaSemana2">
						<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>{{ error2 }}</strong></div>
					</div>
				</div>
				<div ng-show="navs3">
					<div ng-show="tabs3" ng-switch on="(semanaAcumulada[1][1][1]['estado'] == 1) && (semanaAcumulada[0][1][1]['estado'] == 1)">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Acumulado Semanal</h4>
							</div>
						</div>
						<div class="row" ng-switch-when="true">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN RATING %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ ((valores.rating - semanaAcumulada[0][1][tipo]["rating"])/semanaAcumulada[0][1][tipo]["rating"])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td>{{ ((semanaAcumulada[1][1][1]["tvr"] - semanaAcumulada[0][1][1]["tvr"])/semanaAcumulada[0][1][1]["tvr"])*100 | number : 0 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ (((valores.rating/valores.tvr) - (semanaAcumulada[0][1][tipo]["rating"]/semanaAcumulada[0][1][tipo]["tvr"]))/(semanaAcumulada[0][1][tipo]["rating"]/semanaAcumulada[0][1][tipo]["tvr"]))*100 | number : 0 }}</td>
									</tbody>
								</table>	
							</div>
						</div>
						<div class="row"  ng-switch-when="true">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN RATING %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][1].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][1].rating - dataSemana[6]['data'][0][0][1][1]['rating'])/dataSemana[6]['data'][0][0][1][1]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][2].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][2].rating - dataSemana[6]['data'][0][0][1][2]['rating'])/dataSemana[6]['data'][0][0][1][2]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][3].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][3].rating - dataSemana[6]['data'][0][0][1][3]['rating'])/dataSemana[6]['data'][0][0][1][3]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][10].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][10].rating - dataSemana[6]['data'][0][0][1][10]['rating'])/dataSemana[6]['data'][0][0][1][10]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][12].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][12].rating - dataSemana[6]['data'][0][0][1][12]['rating'])/dataSemana[6]['data'][0][0][1][12]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr ng-if="!!dataSemana[6]['data'][0][1][1][16].nombre_corto">
											<td>{{ dataSemana[6]['data'][0][1][1][16].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][16].rating - dataSemana[6]['data'][0][0][1][16]['rating'])/dataSemana[6]['data'][0][0][1][16]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][13].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][13].rating - dataSemana[6]['data'][0][0][1][13]['rating'])/dataSemana[6]['data'][0][0][1][13]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][11].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][11].rating - dataSemana[6]['data'][0][0][1][11]['rating'])/dataSemana[6]['data'][0][0][1][11]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][6].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][6].rating - dataSemana[6]['data'][0][0][1][6]['rating'])/dataSemana[6]['data'][0][0][1][6]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][7].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][7].rating - dataSemana[6]['data'][0][0][1][7]['rating'])/dataSemana[6]['data'][0][0][1][7]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][8].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][8].rating - dataSemana[6]['data'][0][0][1][8]['rating'])/dataSemana[6]['data'][0][0][1][8]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][9].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][9].rating - dataSemana[6]['data'][0][0][1][9]['rating'])/dataSemana[6]['data'][0][0][1][9]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][15].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][15].rating - dataSemana[6]['data'][0][0][1][15]['rating'])/dataSemana[6]['data'][0][0][1][15]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>TVR</td>
											<td> {{ ((dataSemana[6]['data'][0][1][1][1].tvr - dataSemana[6]['data'][0][0][1][1]['tvr'])/dataSemana[6]['data'][0][0][1][1]['tvr'])*100 | number : 0 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][1].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][1].rating/dataSemana[6]['data'][0][1][1][1].tvr) - (dataSemana[6]['data'][0][0][1][1]['rating']/dataSemana[6]['data'][0][0][1][1]['tvr']))/(dataSemana[6]['data'][0][0][1][1]['rating']/dataSemana[6]['data'][0][0][1][1]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][2].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][2].rating/dataSemana[6]['data'][0][1][1][2].tvr) - (dataSemana[6]['data'][0][0][1][2]['rating']/dataSemana[6]['data'][0][0][1][2]['tvr']))/(dataSemana[6]['data'][0][0][1][2]['rating']/dataSemana[6]['data'][0][0][1][2]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][3].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][3].rating/ dataSemana[6]['data'][0][1][1][3].tvr) - (dataSemana[6]['data'][0][0][1][3]['rating']/dataSemana[6]['data'][0][0][1][3]['tvr']))/(dataSemana[6]['data'][0][0][1][3]['rating']/dataSemana[6]['data'][0][0][1][3]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][10].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][10].rating/dataSemana[6]['data'][0][1][1][10].tvr) - (dataSemana[6]['data'][0][0][1][10]['rating']/dataSemana[6]['data'][0][0][1][10]['tvr']))/(dataSemana[6]['data'][0][0][1][10]['rating']/dataSemana[6]['data'][0][0][1][10]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][12].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][12].rating/dataSemana[6]['data'][0][1][1][12].tvr) - (dataSemana[6]['data'][0][0][1][12]['rating']/dataSemana[6]['data'][0][0][1][12]['tvr']))/(dataSemana[6]['data'][0][0][1][12]['rating']/dataSemana[6]['data'][0][0][1][12]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr ng-if="!!dataSemana[6]['data'][0][1][1][16].nombre_corto">
											<td>{{ dataSemana[6]['data'][0][1][1][16].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][16].rating/dataSemana[6]['data'][0][1][1][16].tvr) - (dataSemana[6]['data'][0][0][1][16]['rating']/dataSemana[6]['data'][0][0][1][13]['tvr']))/(dataSemana[6]['data'][0][0][1][16]['rating']/dataSemana[6]['data'][0][0][1][16]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][13].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][13].rating/dataSemana[6]['data'][0][1][1][13].tvr) - (dataSemana[6]['data'][0][0][1][13]['rating']/dataSemana[6]['data'][0][0][1][13]['tvr']))/(dataSemana[6]['data'][0][0][1][13]['rating']/dataSemana[6]['data'][0][0][1][13]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][11].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][11].rating/dataSemana[6]['data'][0][1][1][11].tvr) - (dataSemana[6]['data'][0][0][1][11]['rating']/dataSemana[6]['data'][0][0][1][11]['tvr']))/(dataSemana[6]['data'][0][0][1][11]['rating']/dataSemana[6]['data'][0][0][1][11]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][6].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][6].rating/dataSemana[6]['data'][0][1][1][6].tvr) - (dataSemana[6]['data'][0][0][1][6]['rating']/dataSemana[6]['data'][0][0][1][6]['tvr']))/(dataSemana[6]['data'][0][0][1][6]['rating']/dataSemana[6]['data'][0][0][1][6]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][7].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][7].rating/dataSemana[6]['data'][0][1][1][7].tvr) - (dataSemana[6]['data'][0][0][1][7]['rating']/dataSemana[6]['data'][0][0][1][7]['tvr']))/(dataSemana[6]['data'][0][0][1][7]['rating']/dataSemana[6]['data'][0][0][1][7]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][8].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][8].rating/dataSemana[6]['data'][0][1][1][8].tvr) - (dataSemana[6]['data'][0][0][1][8]['rating']/dataSemana[6]['data'][0][0][1][8]['tvr']))/(dataSemana[6]['data'][0][0][1][8]['rating']/dataSemana[6]['data'][0][0][1][8]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][9].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][9].rating/dataSemana[6]['data'][0][1][1][9].tvr) - (dataSemana[6]['data'][0][0][1][9]['rating']/dataSemana[6]['data'][0][0][1][9]['tvr']))/(dataSemana[6]['data'][0][0][1][9]['rating']/dataSemana[6]['data'][0][0][1][9]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][15].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][15].rating/dataSemana[6]['data'][0][1][1][15].tvr) - (dataSemana[6]['data'][0][0][1][15]['rating']/dataSemana[6]['data'][0][0][1][15]['tvr']))/(dataSemana[6]['data'][0][0][1][15]['rating']/dataSemana[6]['data'][0][0][1][15]['tvr']))*100 | number : 0 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>							
						</div>
						<div class="row" ng-switch-when="false">
							<div class="col-md-12">
								<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>Semana incompleta</strong></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Bandas Horarias</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center" role="toolbar" aria-label="...">
									<div class="btn-group botonera3" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn0 active" ng-click="vsDia(1,3,0)">Lunes</button>
										<button type="button" class="btn btn-default btn1" ng-click="vsDia(1,3,1)">Martes</button>
										<button type="button" class="btn btn-default btn2" ng-click="vsDia(1,3,2)">Miercoles</button>
										<button type="button" class="btn btn-default btn3" ng-click="vsDia(1,3,3)">Jueves</button>
										<button type="button" class="btn btn-default btn4" ng-click="vsDia(1,3,4)">Viernes</button>
										<button type="button" class="btn btn-default btn5" ng-click="vsDia(1,3,5)">Sabado</button>
										<button type="button" class="btn btn-default btn6" ng-click="vsDia(1,3,6)">Domingo</button>
									</div>
									<div class="btn-group botonera3" role="group" aria-label="...">
										<button type="button" class="btn btn-default semana3" ng-click="vsSemana(1,3)">Semana</button>
										<button type="button" class="btn btn-default lav3" ng-click="vsLav(1,3)">L - V</button>
										<button type="button" class="btn btn-default sad3" ng-click="vsSad(1,3)">S - D</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div ng-show="tablaSemana3">
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">RATING %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>S. {{ semana10.informacion.semana }}/{{ semana10.informacion.anio }} vs {{ semana11.informacion.semana }}/{{ semana11.informacion.anio }}</h5>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
										<th rowspan="2" class="text-center">TVR<br/><small>Encendido</small></th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana13" ng-if="key!='promedio'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': parseInt(value.cdfb) < 0}">{{ ((value.cdfb | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfp) < 0}">{{ ((value.cdfp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfhd) < 0}">{{ ((value.cdfhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn) < 0}">{{ ((value.espn | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnm) < 0}">{{ ((value.espnm | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn2) < 0}">{{ ((value.espn2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn3) < 0}">{{ ((value.espn3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnhd) < 0}">{{ ((value.espnhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs) < 0}">{{ ((value.fs | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs2) < 0}">{{ ((value.fs2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs3) < 0}">{{ ((value.fs3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fsp) < 0}">{{ ((value.fsp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.tvr) < 0}">{{ ((value.tvr | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana23">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': parseInt(value.cdfb) < 0}">{{ ((value.cdfb | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfp) < 0}">{{ ((value.cdfp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfhd) < 0}">{{ ((value.cdfhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn) < 0}">{{ ((value.espn | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnm) < 0}">{{ ((value.espnm | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn2) < 0}">{{ ((value.espn2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn3) < 0}">{{ ((value.espn3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnhd) < 0}">{{ ((value.espnhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs) < 0}">{{ ((value.fs | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs2) < 0}">{{ ((value.fs2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs3) < 0}">{{ ((value.fs3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fsp) < 0}">{{ ((value.fsp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.tvr) < 0}">{{ ((value.tvr | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.cdfb < 0]">{{ ((semana13.promedio.cdfb | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.cdfp < 0]">{{ ((semana13.promedio.cdfp | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.cdfhd < 0]">{{ ((semana13.promedio.cdfhd | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.espn < 0]">{{ ((semana13.promedio.espn | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.espnm < 0]">{{ ((semana13.promedio.espnm | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.espn2 < 0]">{{ ((semana13.promedio.espn2 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.espn3 < 0]">{{ ((semana13.promedio.espn3 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.espnhd < 0]">{{ ((semana13.promedio.espnhd | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.fs < 0]">{{ ((semana13.promedio.fs | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.fs2 < 0]">{{ ((semana13.promedio.fs2 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.fs3 < 0]">{{ ((semana13.promedio.fs3 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.fsp < 0]">{{ ((semana13.promedio.fsp | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana13.promedio.tvr < 0]">{{ ((semana13.promedio.tvr | isFinity) | number : 0) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="13" class="text-center">SHARE %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</h5>
											<small>{{ semana12.informacion.fechaInicio}} a {{ semana12.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana13" ng-if="key!='promedio'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': ((((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana23">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': ((((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.cdfb/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.cdfb/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.cdfp/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.cdfp/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.cdfhd/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.cdfhd/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.espn/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.espn/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.espnm/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.espnm/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.espn2/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.espn2/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.espn3/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.espn3/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.espnhd/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.espnhd/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.fs/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.fs/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.fs2/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.fs2/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.fs3/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.fs3/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' :  (((semana13.promedio.fsp/semana13.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana13.promedio.fsp/semana13.promedio.tvr) | isFinity) | number : 0) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" ng-show="errorTablaSemana3">
						<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>{{ error3 }}</strong></div>
					</div>
				</div>
				<div ng-show="navs4">
					<div ng-show="tabs4" ng-switch on="(semanaAcumulada[1][1][1]['estado'] == 1) && (semanaAnteriorAcumulada[1][1][1]['estado'] == 1)">
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Acumulado Semanal</h4>
							</div>
						</div>
						<div class="row" ng-switch-when="true">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN RATING %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ ((valores.rating - semanaAnteriorAcumulada[1][1][tipo]["rating"])/semanaAnteriorAcumulada[1][1][tipo]["rating"])*100 | number : 0 }} %</td>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Grupos</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(tipo, valores) in semanaAcumulada[1][1]" ng-if="tipo != 4" ng-switch on="tipoCanal = tipo" >
											<td ng-switch-when="1">CDF's</td>
											<td ng-switch-when="2">FOX's</td>
											<td ng-switch-when="3">ESPN's</td>
											<td ng-switch-when="5">OTROS</td>
											<td>{{ (((valores.rating/valores.tvr) - (semanaAnteriorAcumulada[1][1][tipo]["rating"]/semanaAnteriorAcumulada[1][1][tipo]["tvr"]))/(semanaAnteriorAcumulada[1][1][tipo]["rating"]/semanaAnteriorAcumulada[1][1][tipo]["tvr"]))*100 | number : 0 }} %</td>
									</tbody>
								</table>	
							</div>
						</div>
						<div class="row"  ng-switch-when="true">
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN RATING %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][1].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][1].rating - dataSemana[6]['data'][1][1][1][1]['rating'])/dataSemana[6]['data'][1][1][1][1]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][2].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][2].rating - dataSemana[6]['data'][1][1][1][2]['rating'])/dataSemana[6]['data'][1][1][1][2]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][3].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][3].rating - dataSemana[6]['data'][1][1][1][3]['rating'])/dataSemana[6]['data'][1][1][1][3]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][10].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][10].rating - dataSemana[6]['data'][1][1][1][10]['rating'])/dataSemana[6]['data'][1][1][1][10]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][12].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][12].rating - dataSemana[6]['data'][1][1][1][12]['rating'])/dataSemana[6]['data'][1][1][1][12]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr ng-if="!!dataSemana[6]['data'][0][1][1][16].nombre_corto">
											<td>{{ dataSemana[6]['data'][0][1][1][16].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][16].rating - dataSemana[6]['data'][1][1][1][16]['rating'])/dataSemana[6]['data'][1][1][1][16]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr >
											<td>{{ dataSemana[6]['data'][0][1][1][13].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][13].rating - dataSemana[6]['data'][1][1][1][13]['rating'])/dataSemana[6]['data'][1][1][1][13]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][11].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][11].rating - dataSemana[6]['data'][1][1][1][11]['rating'])/dataSemana[6]['data'][1][1][1][11]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][6].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][6].rating - dataSemana[6]['data'][1][1][1][6]['rating'])/dataSemana[6]['data'][1][1][1][6]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][7].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][7].rating - dataSemana[6]['data'][1][1][1][7]['rating'])/dataSemana[6]['data'][1][1][1][7]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][8].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][8].rating - dataSemana[6]['data'][1][1][1][8]['rating'])/dataSemana[6]['data'][1][1][1][8]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][9].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][9].rating - dataSemana[6]['data'][1][1][1][9]['rating'])/dataSemana[6]['data'][1][1][1][9]['rating'])*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][15].nombre_corto | uppercase }}</td>
											<td>{{ ((dataSemana[6]['data'][0][1][1][15].rating - dataSemana[6]['data'][1][1][1][15]['rating'])/dataSemana[6]['data'][1][1][1][15]['rating'])*100 | number : 0 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>
							<div class="col-md-6">
								<table class="table table-condensed table-striped table-bordered text-center">
									<thead>
										<tr>
											<th class="text-center" colspan="2"><h5>VARIACIÓN SHARE %</h5></th>
										</tr>
										<tr>
											<th class="text-center">Canales</th>
											<th class="text-center">
												Semana {{ semana10.informacion.semana }} {{ semanaAcumulada[1][1][1].fecha_final  | date : "yyyy" }} {{ semanaAcumulada[1][1][1].fecha_inicio | date : "dd/MM" }} a {{ semanaAcumulada[1][1][1].fecha_final  | date : "dd/MM" }}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][1].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][1].rating/dataSemana[6]['data'][0][1][1][1].tvr) - (dataSemana[6]['data'][1][1][1][1]['rating']/dataSemana[6]['data'][1][1][1][1]['tvr']))/(dataSemana[6]['data'][1][1][1][1]['rating']/dataSemana[6]['data'][1][1][1][1]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][2].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][2].rating/dataSemana[6]['data'][0][1][1][2].tvr) - (dataSemana[6]['data'][1][1][1][2]['rating']/dataSemana[6]['data'][1][1][1][2]['tvr']))/(dataSemana[6]['data'][1][1][1][2]['rating']/dataSemana[6]['data'][1][1][1][2]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][3].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][3].rating/ dataSemana[6]['data'][0][1][1][3].tvr) - (dataSemana[6]['data'][1][1][1][3]['rating']/dataSemana[6]['data'][1][1][1][3]['tvr']))/(dataSemana[6]['data'][1][1][1][3]['rating']/dataSemana[6]['data'][1][1][1][3]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][10].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][10].rating/dataSemana[6]['data'][0][1][1][10].tvr) - (dataSemana[6]['data'][1][1][1][10]['rating']/dataSemana[6]['data'][1][1][1][10]['tvr']))/(dataSemana[6]['data'][1][1][1][10]['rating']/dataSemana[6]['data'][1][1][1][10]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][12].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][12].rating/dataSemana[6]['data'][0][1][1][12].tvr) - (dataSemana[6]['data'][1][1][1][12]['rating']/dataSemana[6]['data'][1][1][1][12]['tvr']))/(dataSemana[6]['data'][1][1][1][12]['rating']/dataSemana[6]['data'][1][1][1][12]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr ng-if="dataSemana[6]['data'][0][1][1][16].nombre_corto">
											<td>{{ dataSemana[6]['data'][0][1][1][16].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][16].rating/dataSemana[6]['data'][0][1][1][13].tvr) - (dataSemana[6]['data'][1][1][1][16]['rating']/dataSemana[6]['data'][1][1][1][16]['tvr']))/(dataSemana[6]['data'][1][1][1][16]['rating']/dataSemana[6]['data'][1][1][1][16]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][13].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][13].rating/dataSemana[6]['data'][0][1][1][13].tvr) - (dataSemana[6]['data'][1][1][1][13]['rating']/dataSemana[6]['data'][1][1][1][13]['tvr']))/(dataSemana[6]['data'][1][1][1][13]['rating']/dataSemana[6]['data'][1][1][1][13]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][11].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][11].rating/dataSemana[6]['data'][0][1][1][11].tvr) - (dataSemana[6]['data'][1][1][1][11]['rating']/dataSemana[6]['data'][1][1][1][11]['tvr']))/(dataSemana[6]['data'][1][1][1][11]['rating']/dataSemana[6]['data'][1][1][1][11]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][6].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][6].rating/dataSemana[6]['data'][0][1][1][6].tvr) - (dataSemana[6]['data'][1][1][1][6]['rating']/dataSemana[6]['data'][1][1][1][6]['tvr']))/(dataSemana[6]['data'][1][1][1][6]['rating']/dataSemana[6]['data'][1][1][1][6]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][7].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][7].rating/dataSemana[6]['data'][0][1][1][7].tvr) - (dataSemana[6]['data'][1][1][1][7]['rating']/dataSemana[6]['data'][1][1][1][7]['tvr']))/(dataSemana[6]['data'][1][1][1][7]['rating']/dataSemana[6]['data'][1][1][1][7]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][8].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][8].rating/dataSemana[6]['data'][0][1][1][8].tvr) - (dataSemana[6]['data'][1][1][1][8]['rating']/dataSemana[6]['data'][1][1][1][8]['tvr']))/(dataSemana[6]['data'][1][1][1][8]['rating']/dataSemana[6]['data'][1][1][1][8]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][9].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][9].rating/dataSemana[6]['data'][0][1][1][9].tvr) - (dataSemana[6]['data'][1][1][1][9]['rating']/dataSemana[6]['data'][1][1][1][9]['tvr']))/(dataSemana[6]['data'][1][1][1][9]['rating']/dataSemana[6]['data'][1][1][1][9]['tvr']))*100 | number : 0 }}</td>
										</tr>
										<tr>
											<td>{{ dataSemana[6]['data'][0][1][1][15].nombre_corto | uppercase }}</td>
											<td>{{ (((dataSemana[6]['data'][0][1][1][15].rating/dataSemana[6]['data'][0][1][1][15].tvr) - (dataSemana[6]['data'][1][1][1][15]['rating']/dataSemana[6]['data'][1][1][1][15]['tvr']))/(dataSemana[6]['data'][1][1][1][15]['rating']/dataSemana[6]['data'][1][1][1][15]['tvr']))*100 | number : 0 }}</td>
										</tr>
									</tbody>
								</table>	
							</div>							
						</div>
						<div class="row" ng-switch-when="false">
							<div class="col-md-12">
								<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>Semana incompleta</strong></div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12 text-center">
								<h4>Bandas Horarias</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="text-center" role="toolbar" aria-label="...">
									<div class="btn-group botonera4" role="group" aria-label="...">
										<button type="button" class="btn btn-default btn0 active" ng-click="vsDia(2,4,0)">Lunes</button>
										<button type="button" class="btn btn-default btn1" ng-click="vsDia(2,4,1)">Martes</button>
										<button type="button" class="btn btn-default btn2" ng-click="vsDia(2,4,2)">Miercoles</button>
										<button type="button" class="btn btn-default btn3" ng-click="vsDia(2,4,3)">Jueves</button>
										<button type="button" class="btn btn-default btn4" ng-click="vsDia(2,4,4)">Viernes</button>
										<button type="button" class="btn btn-default btn5" ng-click="vsDia(2,4,5)">Sabado</button>
										<button type="button" class="btn btn-default btn6" ng-click="vsDia(2,4,6)">Domingo</button>
									</div>
									<div class="btn-group botonera4" role="group" aria-label="...">
										<button type="button" class="btn btn-default semana4" ng-click="vsSemana(2,4)">Semana</button>
										<button type="button" class="btn btn-default lav4" ng-click="vsLav(2,4)">L - V</button>
										<button type="button" class="btn btn-default sad4" ng-click="vsSad(2,4)">S - D</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<br/>
					<div ng-show="tablaSemana4">
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="14" class="text-center">RATING %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>S. {{ semana10.informacion.semana }}/{{ semana10.informacion.anio }} vs {{ semana12.informacion.semana }}/{{ semana12.informacion.anio }}</h5>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
										<th rowspan="2" class="text-center">TVR<br/><small>Encendido</small></th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana14" ng-if="key!='promedio'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': parseInt(value.cdfb) < 0}">{{ ((value.cdfb | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfp) < 0}">{{ ((value.cdfp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfhd) < 0}">{{ ((value.cdfhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn) < 0}">{{ ((value.espn | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnm) < 0}">{{ ((value.espnm | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn2) < 0}">{{ ((value.espn2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn3) < 0}">{{ ((value.espn3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnhd) < 0}">{{ ((value.espnhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs) < 0}">{{ ((value.fs | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs2) < 0}">{{ ((value.fs2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs3) < 0}">{{ ((value.fs3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fsp) < 0}">{{ ((value.fsp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.tvr) < 0}">{{ ((value.tvr | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana24">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': parseInt(value.cdfb) < 0}">{{ ((value.cdfb | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfp) < 0}">{{ ((value.cdfp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.cdfhd) < 0}">{{ ((value.cdfhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn) < 0}">{{ ((value.espn | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnm) < 0}">{{ ((value.espnm | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn2) < 0}">{{ ((value.espn2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espn3) < 0}">{{ ((value.espn3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.espnhd) < 0}">{{ ((value.espnhd | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs) < 0}">{{ ((value.fs | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs2) < 0}">{{ ((value.fs2 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fs3) < 0}">{{ ((value.fs3 | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.fsp) < 0}">{{ ((value.fsp | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': parseInt(value.tvr) < 0}">{{ ((value.tvr | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.cdfb < 0]">{{ ((semana14.promedio.cdfb | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.cdfp < 0]">{{ ((semana14.promedio.cdfp | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.cdfhd < 0]">{{ ((semana14.promedio.cdfhd | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.espn < 0]">{{ ((semana14.promedio.espn | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.espnm < 0]">{{ ((semana14.promedio.espnm | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.espn2 < 0]">{{ ((semana14.promedio.espn2 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.espn3 < 0]">{{ ((semana14.promedio.espn3 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.espnhd < 0]">{{ ((semana14.promedio.espnhd | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.fs < 0]">{{ ((semana14.promedio.fs | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.fs2 < 0]">{{ ((semana14.promedio.fs2 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.fs3 < 0]">{{ ((semana14.promedio.fs3 | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.fsp < 0]">{{ ((semana14.promedio.fsp | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{true: 'danger'}[semana14.promedio.tvr < 0]">{{ ((semana14.promedio.tvr | isFinity) | number : 0) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row">
							<table class="table table-condensed table-striped table-bordered text-center">
								<thead>
									<tr>
										<th colspan="13" class="text-center">SHARE %</th>
									</tr>
									<tr>
										<th colspan="2" rowspan="2" class="text-center" style="	vertical-align: middle">
											<h5>Semana {{ semana12.informacion.semana }} {{ semana12.informacion.anio }}</h5>
											<small>{{ semana12.informacion.fechaInicio}} a {{ semana12.informacion.fechaFinal }}</small>
										</th>
										<th colspan="3" class="text-center">CDF'S</th>
										<th colspan="4" class="text-center">ESPN'S</th>
										<th colspan="4" class="text-center">FOX SPORTS'S</th>
									</tr>
									<tr>
										<th class="text-center">CDF</th>
										<th class="text-center">CDFP</th>
										<th class="text-center">CDFHD</th>
										<th class="text-center">ESPN</th>
										<th class="text-center">ESPN+</th>
										<th class="text-center">ESPN2</th>
										<th class="text-center">ESPN3</th>
										<th class="text-center">ESPNHD</th>
										<th class="text-center">FS</th>
										<th class="text-center">FS2</th>
										<th class="text-center">FS3</th>
										<th class="text-center">FSP</th>							
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="(key,value) in semana14" ng-if="key!='promedio'">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': ((((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr ng-repeat="(key,value) in semana24">
										<td>{{ key | parseInt }}:00</td>
										<td ng-if="key != 23">{{ (key | parseInt) + 1 }}:00</td>
										<td ng-if="key == 23">00:00</td>
										<td ng-class="{'danger': ((((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfb/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.cdfhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnm/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espn3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.espnhd/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs2/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fs3/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
										<td ng-class="{'danger': ((((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada) < 0}">{{ (((value.fsp/value.tvr) | isFinity) | number : 0) | ceroNada }}</td>
									</tr>
									<tr>
										<td colspan="2" style="vertical-align: middle"><strong>Promedio<br/>07:00 - 02:00</strong></td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.cdfb/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.cdfb/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.cdfp/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.cdfp/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.cdfhd/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.cdfhd/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.espn/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.espn/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.espnm/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.espnm/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.espn2/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.espn2/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.espn3/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.espn3/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.espnhd/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.espnhd/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.fs/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.fs/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.fs2/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.fs2/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.fs3/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.fs3/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
										<td style="vertical-align: middle" ng-class="{'danger' : (((semana14.promedio.fsp/semana14.promedio.tvr) | isFinity) | number : 0) < 0}">{{ (((semana14.promedio.fsp/semana14.promedio.tvr) | isFinity) | number : 0) }}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="row" ng-show="errorTablaSemana4">
						<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert"><strong>{{ error4 }}</strong></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div ng-show="sinData">
					<div class="alert alert-danger col-md-8	col-md-offset-2 text-center" role="alert">No se encontro ninguna informacion para la semana solicitada</strong></div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/controladores/rating_minutos',
	'angularjs/factorias/rating_minutos', 
	'angularjs/servicios/rating_minutos',
	'angularjs/servicios/servicios', 
	'angularjs/filtros/filtros',
	'angularjs/angular-locale_es-cl',
	'bootstrap-datepicker'
	)
);
?>

<script type="text/javascript">

	$('.fecha').datepicker({
		format: "dd/mm/yyyy",
		language: "es",
		multidate: false,
		autoclose: true,
		required: true,
		calendarWeeks: true,
		weekStart:1,
		endDate: '-1d',
	});

</script>