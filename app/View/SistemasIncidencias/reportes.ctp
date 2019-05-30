<div ng-controller="sistemasIncidenciaReportes" ng-cloak ng-init="anioInicial('<?php echo date("Y");?>')">
<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form class="form-horizontal">
					<div class="form-group">
						<label class="control-label text-right col-md-4">Año</label>
						<div class="col-md-6"> 
							<select class="form-control" ng-model="anioBusqueda" ng-change="cambioAnio(anioBusqueda)" ng-options="item as item.id for item in ingresosCierres track by item.id ">
						
							</select>	
						</div>
					</div>
				</form>	 
			</div>
			<div class="row">
				<div class="col-md-12">
		            <highchart id="chart1" config="chart1"></highchart>
		        </div>
			</div>
		
				<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<table class="table table-striped table-bordered" style="font-size: 12px">
						<tr>
							<td class="text-center success"><b>Total Incidencias</b></td>
							<td class="text-center success"><b>Total Solucionadas</b></td>
							<td class="text-center success"><b>Total en Revisión</b></td>
						</tr>
						<tr>
							<td class="text-center"><b>{{tabla1.total}}</b></td>
							<td class="text-center"><b>{{tabla1.resueltas}}</b></td>
							<td class="text-center"><b>{{tabla1.revision}}</b></td>
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
	"angularjs/servicios/sistemas_incidencias/sistemas_incidencias",
	"angularjs/factorias/factoria",
	"angularjs/controladores/sistemas_incidencias/sistemas_incidencias",
	'highcharts-grouped-categories.min',
	"select2.min"
));
?>