<style>
	.container{
		width: 90%;
	}
</style>
<div ng-controller="abonadosCtrl">

	<div class="col-md-4 col-md-offset-4"> 
		<input id="fechaDesde" class="form-control" type="text" required="required" name="fechaDesde" placeholder="Seleccione una fecha" ng-model="fecha" ng-change="onEditChange()">
	</div>
	<br/>
	<br/>
	<br/>
	<br/>
	<!--p ng-bind-html="cargador" ng-show="loader"></p-->
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-justified">
			<li id="basico" role="presentation" class="{{activoBasico}}" ng-click="segnal(1)"><a href="#">Cdf Señal Básica</a></li>
			<li role="presentation" class="{{activoPremium}}" ng-click="segnal(2)"><a href="#">Cdf Señal Premium</a></li>
			<li role="presentation" class="{{activoHd}}" ng-click="segnal(3)"><a href="#">Cdf Señal Hd</a></li>
			<li role="presentation" class="{{activoPenetracion}}" ng-click="segnal(4)"><a href="#">Penetración Premium / Básico</a></li>
		</ul>
	</div>
	<br/>
	<br/>
	<div>
		<h3 class="text-center" ng-show="showTitulo">Evolución abonados {{titulo}}</h3>
	    <highchart id="chart1" config="highchartsNG"></highchart>
	    <br/>

	    <table class="table table-striped table-bordered" ng-show="tablaAbonados">
	    	<caption>Señal {{titulo}}</caption>
	    	<thead>
	    		<tr>
	    			<th></th>
	    			<th ng-repeat="value in cabecera track by $index">{{value}}</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<tr>
	    			<td><strong>DirecTv</strong></td>
	    			<td ng-repeat="value in direcTv track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Movistar</strong></td>
	    			<td ng-repeat="value in movistar track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Claro</strong></td>
	    			<td ng-repeat="value in claro track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Vtr</strong></td>
	    			<td ng-repeat="value in vtr track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Entel</strong></td>
	    			<td ng-repeat="value in entel track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Gtd</strong></td>
	    			<td ng-repeat=" value in gtd track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Telsur</strong></td>
	    			<td ng-repeat="value in telsur track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>otros</strong></td>
	    			<td ng-repeat="value in otros track by $index">{{value | currency:"":0}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Total</strong></td>
	    			<td ng-repeat="value in totalAbonados track by $index">{{value | currency:"":0}}</td>
	    		</tr>

	    		<!--tr>
	    			<td><strong>Telsur</strong></td>
	    			<td ng-repeat="(key, value) in otrosX">{{value}}</td>
	    		</tr-->
	    	</tbody>
	    </table>


	    <table class="table table-striped table-bordered" ng-show="tablaPenetracion">
	    	<caption>{{titulo}}</caption>
	    	<thead>
	    		<tr>
	    			<th></th>
	    			<th ng-repeat="value in cabecera track by $index">{{value}}</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		<tr>
	    			<td><strong>DirecTv</strong></td>
	    			<td ng-repeat="value in penetracionDirectv track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Movistar</strong></td>
	    			<td ng-repeat="value in penetracionMovistar track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Claro</strong></td>
	    			<td ng-repeat="value in penetracionClaro track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Vtr</strong></td>
	    			<td ng-repeat="value in penetracionVtr track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Entel</strong></td>
	    			<td ng-repeat="value in penetracionEntel track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Gtd</strong></td>
	    			<td ng-repeat=" value in penetracionGtd track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		<tr>
	    			<td><strong>Telsur</strong></td>
	    			<td ng-repeat="value in penetracionTelsur track by $index">{{value | currency:"":2}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Otros</strong></td>
	    			<td ng-repeat="value in penetracionOtros track by $index">{{value | currency:"":2}}</td>
	    		</tr>

	    		<tr>
	    			<td><strong>Total</strong></td>
	    			<td ng-repeat="value in totalesPenetracion track by $index">{{value | currency:"":2}}</td>
	    		</tr>
	    		
	    	</tbody>
	    </table>
	 </div>
</div>
<?php
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/controladores/abonados/abonadosControler',
		'angularjs/servicios/abonados/abonados',
	));
?>

<script>
	$('#fechaDesde').datepicker({
		    format: "yyyy-mm-dd",
		   // startView: 1,
		    startDate: "2014-01-01",
		    language: "es",
		    multidate: false,
		    daysOfWeekDisabled: "0, 6",
		    autoclose: true,
		    viewMode: "months", 
   			minViewMode: "months"
	    });	

	$("#fechaDesde").change(function(){
		setTimeout(function(){
		  $("#basico").trigger('click')
		}, 1000);
	});

</script>