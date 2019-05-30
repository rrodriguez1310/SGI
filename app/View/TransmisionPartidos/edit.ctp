<style>input {margin-top: 0px;}
	.btn-xs{margin-top: -18px;
	}
</style>

<div ng-controller="TransmisionControllerForm" ng-init="idTransmision = <?php echo $id; ?>">
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
							<div class="col-xs-10 offset-2">
								<div class="form-group">
									<label ng-repeat="medio in posiciones" style="font-size: 15px;">
										<input ng-click="cambioPosiciones(medio.id)" ng-model="posicion" type="radio" name="medio" ng-value="medio.id" autocomplete="off" > {{medio.nombre}}
									</label>
								</div>
								
								<div class="form-group">
									<label class="col-md-2 control-label">Medio de Transmisión</label>
									<div class="col-md-5">
										<ui-select ng-change="cambiaMedio($select.selected.id, posicion)" ng-model="transmisionPosiciones[posicion].medio" required>
											<ui-select-match placeholder="Seleccione un Medio de Transmisión">
												{{$select.selected.nombre}}
											</ui-select-match>
											<ui-select-choices repeat="medio.id as medio in medios">
												<div ng-bind-html="medio.nombre"></div>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Operación</label>
									<div class="col-md-5">
										<ui-select ng-disabled="!transmisionPosiciones[posicion].medio" ng-model="transmisionPosiciones[posicion].senal" ng-change="cambia(posicion)" required>
											<ui-select-match placeholder="Seleccione una Señal">
												{{$select.selected.nombre}}
											</ui-select-match>
											<ui-select-choices repeat="senal.id as senal in transmisionSenales[posicion]">
												<div ng-bind-html="senal.nombre"></div>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>

								<!-- Solo para "Otro"-->
								<div class="form-group" ng-if="posicion==='respaldo_otro_meta'">
									<label class="col-md-2 control-label">Canal</label>
									<div class="col-md-5">
										<ui-select ng-model="formulario[posicion].canal" required>
											<ui-select-match placeholder="Seleccione un Canal">
												{{$select.selected.nombre}}
											</ui-select-match>
											<ui-select-choices repeat="canal.id as canal in canales">
												<div ng-bind-html="canal.nombre"></div>
											</ui-select-choices>
										</ui-select>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-2 control-label">Puesta en Marcha</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="puesta_marcha" name="puesta_marcha" ng-model="formulario[posicion].puesta_marcha" placeholder="Ingresa Puesta en Marcha">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Contacto Estadio</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="contacto" name="contacto" ng-model="formulario[posicion].contacto" placeholder="Ingresa Contacto Estadio">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Recepción de señal en CDF</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="recepcion" name="recepcion" ng-model="formulario[posicion].recepcion" placeholder="Ingresa Recepción Señal en CDF">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Anexo</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="anexo" name="anexo" ng-model="formulario[posicion].anexo" placeholder="Ingresa Anexo">
									</div>
								</div>
							</div>
							
							<div class="col-md-12 text-center">
								<div class="form-group">
									<button type="button" ng-disabled="!deshabilitado" ng-click="editarTransmision()" class="btn btn-lg btn-primary">Guardar <i class="fa fa-pencil"></i></button>
					               <a href="<?php echo $this->request->referer(); ?>" class="btn btn-default btn-lg center margin-t-10">
									 <i class="fa fa-mail-reply-all"></i>  Volver
									</a>
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
