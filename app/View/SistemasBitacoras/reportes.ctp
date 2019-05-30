<div ng-controller="sistemasBitacorasReportes" ng-cloak ng-init="anioInicial('<?php echo date("Y");?>')">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="showFecha">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="control-label text-right col-md-4">Año</label>
						<div class="col-md-6">
							<select class="form-control" ng-model="anioBusqueda" ng-change="cambioAnio(anioBusqueda)" ng-options="anios for anios in ingresosCierres.anios | orderBy : anios : true">
							</select>	
						</div>
					</div>
				</form>	 
			</div>
		</div>
	</div>
	<div ng-if="ShowContenido">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div id="secciones">
					<ul class="nav nav-tabs">
						<li role="presentation" class="active" id="nav1"><a href="" ng-click="mostrarSeccion(1)">Ingreso Tareas</a></li>
						<li role="presentation" id="nav2"><a href="" ng-click="mostrarSeccion(2)">Cierre Tareas</a></li>
						<li role="presentation" id="nav3"><a href="" ng-click="mostrarSeccion(3)">Áreas</a></li>
					</ul>	
				</div>
			</div>
		</div>
		<br />
		<div ng-if="ingresoTareas">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="{{numResponsables+1}}">
									<h4>
										Ingreso de tarea  {{ anioBusqueda }}
									</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Meses</th>
								<th class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{data.nombre}}<span ng-if="data.admin==1"> (Adm)</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="mes in meses">
								<td class="text-center">{{ mes.nombre | capitalize }}</td>
								<td class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{ingresosCierres.inicio.valores[anioBusqueda][idResponsable][mes.mes] | undefinedPorValor : ""}}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{ingresosCierres.inicio.total[anioBusqueda][idResponsable] | undefinedPorValor : ""}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart" config="chart"></highchart>
		        </div>
			</div>
		</div>
		<div ng-if="cierresTareas">
			<div class="row">
				<div class="col-md-10 col-md-offset-1">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="{{numResponsables+1}}">
									<h4>
										Cierre de tarea  {{ anioBusqueda }}
									</h4>
								</th>
							</tr>
							<tr>
								<th class="text-center">Meses</th>
								<th class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{data.nombre}}<span ng-if="data.admin==1"> (Adm)</span></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="mes in meses">
								<td class="text-center">{{ mes.nombre | capitalize }}</td>
								<td class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{ingresosCierres.cierre.valores[anioBusqueda][idResponsable][mes.mes] | undefinedPorValor : ""}}</td>
							</tr>
							<tr class="success">
								<td class="text-center">Total</td>
								<td class="text-center" ng-repeat="(idResponsable, data) in ingresosCierres.responsables">{{ingresosCierres.cierre.total[anioBusqueda][idResponsable] | undefinedPorValor : ""}}</td>
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
		<div ng-if="bitacorasAreas">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form class="form-horizontal">
						<div class="form-group">
							<label class="control-label text-right col-md-4">Area</label>
							<div class="col-md-6">
								<select2 class="form-control" ng-model="modeloArea.areaBusqueda" id="area" name="area" ng-change="cambioArea(modeloArea.areaBusqueda)" s2-options="area.id as area.nombre for area in areas">
								</select2>	
							</div>
						</div>
					</form>	
				</div>
			</div>
			<div ng-show="dataArea.length!=0">
				<div class="row">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped table-bordered">
							<thead>
								<tr>
									<th class="text-center" colspan="2">
										<h4>
											Bitacoras áreas {{areaPorId[modeloArea.areaBusqueda].nombre}} {{ anioBusqueda }}
										</h4>
									</th>
								</tr>
								<tr>
									<th class="text-center">Meses</th>
									<th class="text-center">Cantidad</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="mes in meses">
									<td class="text-center">{{ mes.nombre | capitalize }}</td>
									<td class="text-center"><button ng-if="(dataArea.data.meses[mes.mes].total)" class="btn btn-default" style="margin-top:0px" ng-click="detalleArea(mes.mes)">{{ dataArea.data.meses[mes.mes].total }}</button></td>
								</tr>
								<tr class="success">
									<td class="text-center">Total</td>
									<td class="text-center">{{dataArea.data.total}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
			            <highchart id="chart3" config="chart3"></highchart>
			        </div>
				</div>
			</div>
		</div>
	</div>
	<modal visible="showModal">
		<div class="row">
			<div class="col-md-12">
				<table  class="table table-striped table-bordered">
					<thead>
						<tr>
							<th class="text-center" colspan="2">
								Detalle {{areaPorId[modeloArea.areaBusqueda].nombre}} {{mesesPorNumero[mesDetalle].nombre | capitalize}} {{ anioBusqueda }}
							</th>
						</tr>
						<tr>
							<th class="text-center">Nombre</th>
							<th class="text-center">Cantidad</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="detalle in detalleAreaData">
							<td class="text-center">{{detalle.name | capitalize}}</td>
							<td class="text-center">{{detalle.y}}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
				<div class="col-md-12 text-center">
		            <highchart id="chart4" config="chart4"></highchart>
		        </div>
			</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col-md-12 text-center">
	        		<button type="button" class="btn btn-default" ng-click="showModal = false" data-dismiss="modal"><i class="fa fa-reply-all"></i> Cerrar</button>		
				</div>
			</div>
	    </div>
	</modal>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/directivas/modal/modal",
	"angularjs/filtros/filtros",
	"angularjs/servicios/sistemas_bitacoras/sistemas_bitacoras",
	"angularjs/factorias/factoria",
	"angularjs/controladores/sistemas_bitacoras/sistemas_bitacoras",
	"select2.min"
));
?>