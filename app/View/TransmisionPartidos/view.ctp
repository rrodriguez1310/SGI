<style>input {margin-top: 0px;}
	.btn-xs{margin-top: -18px;}
	.def{font-weight:100;display:inline-block;}
</style>

<div ng-controller="TransmisionControllerView" ng-init="idTransmision = <?php echo $id; ?>">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-hide="loader">
		<div class="col-sm-12">
			<h3>Producción de Partidos</h3>
			<div class="panel panel-default">
				<div class="panel-heading"><h4>Transmisión de Partido</h4></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tr> 
										<th>Equipos:</th>
										<td>{{produccion.equipos}}</td>
									</tr>
									<tr>
										<th>Estadio:</th>
										<td>{{produccion.estadio}} , {{produccion.estadio_ciudad}}, {{produccion.estadio_region}} {{produccion.estadio_region==="RM" ? "" : " REGIÓN"}}</td>
									</tr>
									<tr>
										<th>Campeonato:</th>
										<td>{{produccion.campeonato}} - {{produccion.categoria}}</td>
									</tr>	
									<tr>
										<th>Fecha Partido:</th>
										<td>{{produccion.fecha_partido_str}}</td>
									</tr>	
									<tr>
										<th>N° Partido:</th>
										<td>{{produccion.nPartido}}</td>
									</tr>
								</table>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="table-responsive">
								<table class="table table-bordered table-hover">
									<tr>
										<th>Inicio Transmisión:</th>
										<td>{{produccion.inicio_transmision}} HORA LOCAL - {{produccion.inicio_transmision_gmt}} GMT</td>
									</tr>	
									<tr>
										<th>Inicio Partido:</th>
										<td>{{produccion.inicio_partido}} HORA LOCAL - {{produccion.inicio_partido_gmt}} GMT</td>
									</tr>	
									<tr>
										<th>Fin Aprox. Transmisión:</th>
										<td>{{produccion.fin_aprox_transmision}} HORA LOCAL - {{produccion.fin_aprox_transmision_gmt}} GMT</td>
									</tr>
									<tr>
										<th>Producción Técnica:</th>
										<td>{{produccion.produccion_tecnica}}  - {{produccion.movile}}</td>
									</tr>
									<tr>
										<th>Observación:</th>
										<td>
											{{produccion.senal === "HD" ? "Transmision HD" : ""}}
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default">
			    <div class="panel-heading"><h4>Transporte de Señal</h4></div>
			    <div class="panel-body">
	  				<div class='form-row'>
  						<form class="form-horizontal" name="transporteEditForm" novalidate>
							<input type="hidden" ng-model="formulario.transmision.id">
							<input type="hidden" ng-model="formulario.produccion.id">	
							<div class="col-xs-10 offset-2">
								<div class="form-group">
									<label ng-repeat="medio in posiciones" style="font-size: 15px;">
										<input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off" > {{medio.nombre}}
									</label>
								</div>
							</div>
			  				<div class='col-xs-12'>
								<div class="form-group">
									<label class="col-md-3 text-left">Medio de Transmisión :</label>
									<label class="col-md-4 def">
												{{transmisionPosiciones[posicion].medio}}</label>
								</div>
								<div class="form-group">
									<label class="col-md-3 text-left">Operación :</label>
									<label class="col-md-4 def">
												{{transmisionPosiciones[posicion].senal}}</label>
								</div>
								<div class="form-group" ng-if="posicion==='respaldo_otro_meta'">
									<label class="col-md-3 text-left">Canal :</label>
									<label class="col-md-4 def">
												{{canalNombre}}</label>
								</div>
								<div class="form-group">
									<label class="col-md-3 text-left">Puesta en Marcha :</label>
									<label class="col-md-4 def">
												{{formulario[posicion].puesta_marcha}}</label>
								</div>
								<div class="form-group">
									<label class="col-md-3 text-left">Contacto Estadio :</label>
									<label class="col-md-4 def">
												{{formulario[posicion].contacto}}</label>
								</div>
								<div class="form-group">
									<label class="col-md-3 text-left">Recepción de señal en CDF :</label>
									<label class="col-md-4 def">
												{{formulario[posicion].recepcion}}</label>
								</div>
								<div class="form-group">
									<label class="col-md-3 text-left">Anexo :</label>
									<label class="col-md-4 def">
										{{formulario[posicion].anexo}}
									</label>									
								</div>
							</div>
						</form>	
					</div>
    			</div>
		  	</div>
		</div>
	</div>	
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/transmisionPartidos/transmisionPartidos',
		'angularjs/controladores/transmisionPartidos/transmisionPartidos'
	));
?>
