<style>
	.container{
		width: 90%;
	}
</style>
<div ng-controller="abonadosCtrl">
	<div class="row">
		<div class="col-md-4 col-md-offset-4"> 
			<input id="fechaDesde" class="form-control" type="text" required="required" name="fechaDesde" placeholder="Seleccione una fecha" ng-model="fecha" ng-change="seleccionaFecha()">
		</div>
	</div>
	<br/>
	<br/>
	<br/>
	<div class="row">
		<div class="col-md-12">
			<ul class="nav nav-tabs nav-justified">
				<li id="basico" role="presentation" class="{{activoBasico}}" ng-click="segnal(1)"><a href="#">Cdf Señal Basica</a></li>
				<li role="presentation" class="{{activoPremium}}" ng-click="segnal(2)"><a href="#">Cdf Señal Premium</a></li>
				<li role="presentation" class="{{activoHd}}" ng-click="segnal(3)"><a href="#">Cdf Señal Hd</a></li>
				<li role="presentation" class="{{activoPenetracion}}" ng-click="segnal(4)"><a href="#">Penetración Premium / Basico</a></li>
			</ul>
		</div>
	</div>

	<div class="row">
		<h3 class="text-center" ng-show="showTitulo">Evolucion abonados {{tituloGraficos}}</h3>
		<highchart id="chart1" config="highchartsNG"></highchart>
	</div>

		<table class="table table-striped table-bordered" ng-show="tablaDetalle">
	    	<caption>{{tituloGraficos}}</caption>
	    	<thead>
	    		<tr>
	    			<th></th>
	    			<th ng-repeat="value in cabecera track by $index">{{value}}</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<tr>
	    			<td><strong>DirecTv</strong></td>
	    			<td ng-repeat="value in abonadosDirecTv track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Movistar</strong></td>
	    			<td ng-repeat="value in abonadosMovistar track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Claro</strong></td>
	    			<td ng-repeat="value in abonadosClaro track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Vtr</strong></td>
	    			<td ng-repeat="value in abonadosVtr track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Entel</strong></td>
	    			<td ng-repeat="value in abonadosEntel track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Gtd</strong></td>
	    			<td ng-repeat="value in abonadosGtd track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Telsur</strong></td>
	    			<td ng-repeat="value in abonadosTelSur track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Otros</strong></td>
	    			<td ng-repeat="value in abonadosOtros track by $index">{{value | currency:"":decimales}}</td>
	    		</tr>
	    	</tbody>
	    </table>
</div>

<?php
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/controladores/abonados/abonadosDosController',
		'angularjs/servicios/abonados/abonadosDos',
	));
?>

<script>
	$('#fechaDesde').datepicker({
		format: "yyyy-mm-dd",
	    //startView: 1,
	    startDate: "2004-01-01",
	    language: "es",
	    multidate: false,
	    daysOfWeekDisabled: "0, 6",
	    autoclose: true,
	    viewMode: "months", 
		minViewMode: "months"
    });

</script>