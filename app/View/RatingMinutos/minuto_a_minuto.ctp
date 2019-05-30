<div ng-controller="mainRatingMinutos" ng-cloak>
	<div ng-controller="informe_minutos">
		<div class="col-md-12">
			<div class="row">
				<form class="form-inline">
					<div class="form-group col-md-2 col-md-offset-4">
						<label for="exampleInputName2">Fecha</label>
						<div class="input text">
							<input type="text" class="form-control fecha readonly-pointer-background"  readonly placeholder="Seleccione fecha" ng-model="fecha">							
						</div>
					</div>
					<div class="form-group clockpicker col-md-2">
						<label for="exampleInputEmail2">Hora</label>
						<div class="input text">
							<input type="text" class="form-control readonly-pointer-background" readonly id="horaInicio" placeholder="Seleccione hora inicial" ng-model="horaInicio">	
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button class="btn btn-primary col-md-offset-4 col-md-4" ng-click="buscar_minutos()">Buscar</button>	
						</div>
					</div>
				</form>
			</div>
			<br/>
			<br/>
			<p ng-bind-html="cargador" ng-show="loader"></p>
			<div ng-if="detalleMinutos==true">
				<div class="row">
					<div class="col-md-12">
			            <highchart id="chart1" config="chartConfig"></highchart>
			        </div>
			    </div>
		        <br/>
		        <br/>	
				<div class="row">
					<div class="table-responsive text-center" style="overflow:auto">
						<table class="table table-condensed table-bordered table-striped" style="text-align:center">
							<thead>
								<tr>
									<th rowspan="2" class="text-center">Minuto</th>
									<th colspan="11" class="text-center" style="border-right: 2px solid;">RATING% HCC</th>
									<th colspan="11" class="text-center">SHARE% HCC</th>
								</tr>
								<tr>
									<th style="text-align:center">CDFBx</th>
									<th style="text-align:center">CDFP</th>
									<th style="text-align:center">CDFHD</th>
									<th style="text-align:center">ESPN</th>
									<th style="text-align:center">ESPN+</th>
									<th style="text-align:center">ESPN2</th>
									<th style="text-align:center">ESPN3</th>
									<th style="text-align:center">ESPNHD</th>									
									<th style="text-align:center">FS</th>
									<th style="text-align:center">FSP</th>
									<th style="text-align:center">FS2</th>
									<th style="border-right: 2px solid; text-align:center">FS3</th>
									<th style="text-align:center">CDFB</th>
									<th style="text-align:center">CDFP</th>
									<th style="text-align:center">CDFHD</th>
									<th style="text-align:center">ESPN</th>
									<th style="text-align:center">ESPN+</th>
									<th style="text-align:center">ESPN2</th>
									<th style="text-align:center">ESPN3</th>
									<th style="text-align:center">ESPNHD</th>									
									<th style="text-align:center">FS</th>
									<th style="text-align:center">FSP</th>
									<th style="text-align:center">FS2</th>
									<th style="text-align:center">FS3</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="(minuto, detalle) in minutos">
									<td>{{ minuto.substring(11, 16) }}</td>
									<td>{{ (detalle.cddatafb | number : 2) | ceroNada }}</td>
									<td>{{ (detalle.cdfp | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.cdfhd | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.espn | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.espnm | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.espn2 | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.espn3 | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.espnhd | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.fs | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.fsp | number : 2) | ceroNada}}</td>
									<td>{{ (detalle.fs2 | number : 2) | ceroNada}}</td>
									<td style="border-right: 2px solid;">{{ (detalle.fs3 | number : 2) | ceroNada }}</td>
									<td>{{ (((detalle.cddatafb/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.cdfp/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.cdfhd/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.espn/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.espnm/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.espn2/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.espn3/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.espnhd/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.fs/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.fsp/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.fs2/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
									<td>{{ (((detalle.fs3/detalle.tvr)*100) | number :2 ) | porcentajeNada }}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div ng-show="alerta">
				<div class="row">
					<div class="alert alert-danger col-md-4 col-md-offset-4" role="alert">No se encontro información en la busqueda</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->css('bootstrap-clockpicker.min');
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/rating_minutos',
		'angularjs/factorias/rating_minutos', 
		'angularjs/servicios/rating_minutos',
		'angularjs/servicios/servicios', 
		'angularjs/filtros/filtros',
		'angularjs/angular-locale_es-cl',
		'bootstrap-datepicker',
		'bootstrap-clockpicker.min'
	));
?>
<script type="text/javascript">
	$('.clockpicker').clockpicker({
		placement:'bottom',
		align: 'top',
		autoclose:true
	});
	$('.fecha').datepicker({
		format: "dd/mm/yyyy",
		language: "es",
		multidate: false,
		autoclose: true,
		required: true,
		weekStart:1,
		endDate: '-1d',
	});

</script>
