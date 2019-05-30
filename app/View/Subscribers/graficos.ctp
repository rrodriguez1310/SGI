<div ng-controller="graficosSubscribersCtrl" ng-cloak>
	<div class="row" style="padding: 0px 20px">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<?php echo $this->Form->create('Subscriber', [
						"name" => "subscribersGraficosForm",
						//"class" => "form-horizontal",
						"novalidate",
						"inputDefaults" => [
							"div" => "form-group",
							"required"
						]
					]); ?>
					<?php
						echo $this->Form->input('year_id', array("ng-model" => "yearId", "class"=>"col-md-2 form-control", "label" => ["text"=>"Año", "class" => "control-label"]));
						echo $this->Form->input('month_id', array("ng-model" => "monthId", "class"=>"col-md-2 form-control", "label" => ["text"=>"Mes", "class" => "control-label"]));
					?>
					<?php echo $this->Form->end(); ?>
					<div class="form-group text-center">
						<button class="btn btn-lg btn-primary" ng-click="buscarDatos()" ng-disabled="subscribersGraficosForm.$invalid || evolucionSubscribers.loading"><i class="fa fa-search-plus"></i> Buscar</button>
					</div>
				</div>	
			</div>
			<div class="row" ng-show="activo != undefined">
				<div class="col-md-12">
					<div>
						<ul class="nav nav-tabs nav-justified" role="tablist">
							<li role="presentation" ng-class="{'active' : (activo == 1)}"><a href="" ng-click="canal(1)">Cdf Señal Basica</a></li>
							<li role="presentation" ng-class="{'active' : (activo == 2)}"><a href="" ng-click="canal(2)">Cdf Señal Premium</a></li>
							<li role="presentation" ng-class="{'active' : (activo == 3)}"><a href="" ng-click="canal(3)">Cdf Señal Hd</a></li>
							<li role="presentation" ng-class="{'active' : (activo == 0)}"><a href=""ng-click="penetracion()">Penetración Premium / Basico</a></li>
						</ul>
					</div>
				</div>
			</div>
			<br />
			<div class="row" ng-if="evolucionSubscribers.series != 0">
				<div class="col-md-12">
		            <highchart id="evolucionSubscribers" config="evolucionSubscribers"></highchart>
		        </div>
			</div>
			<br/>
			<div class="row" ng-if="evolucionSubscribers.series != 0">
				<div class="col-md-12">
					<div class="table-responsive">
			            <table class="table table-striped table-bordered table-condensed">
			            	<thead>
			            		<tr class="info">
			            			<th>Empresa</th>
			            			<th ng-repeat="value in evolucionSubscribers.options.xAxis.categories">{{value}}</th>
			            		</tr>
			            	</thead>
			            	<tbody>
			            		<tr ng-repeat="rows in evolucionSubscribers.series" ng-class="{'success' : (rows.name == 'TOTALES')}">
			            			<td>{{rows.name}}</td>
			            			<td ng-repeat="abonados in rows.data track by $index" class="text-right">{{abonados | number}}{{(activo == 0) ? "%" : ''}}</td>
			            		</tr>
			            	</tbody>
			            </table>
			        </div>
		        </div>
			</div>
			<div class="row" ng-show="(activo != undefined && evolucionSubscribers.series == 0) ? true : false">
				<div class="col-md-12 text-center">
					<div class="alert alert-warning" role="alert"><h3><strong>Sin informacíon</strong></h3></div>
				</div>
			</div>		
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		"highcharts-no-data-to-display",
		"angularjs/controladores/app.js",
		"angularjs/servicios/subscribers/subscribers.js",
		"angularjs/servicios/years/years.js",
		"angularjs/servicios/months/months.js",
		"angularjs/controladores/subscribers/subscribers.js"
	));
?>