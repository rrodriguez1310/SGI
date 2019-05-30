<div ng-controller="catalogacionPartidosEdit" ng-cloak ng-init="idCatalogacionPartido(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
		<div ng-show="detalle">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Ingresar evento partido</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form class="form-horizontal" name="ingestasAddForm" novalidate>
					<div class="form-group">
						<label class="control-label col-md-3 baja" for="equipoLocal">
							Codigo
						</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="codigo" name="codigo" ng-model="formulario.CatalogacionPartido.codigo" readonly="readonly">	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.equipoLocal.$valid }">
						<label class="control-label col-md-3" for="equipoLocal">
							Equipo local
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartido.equipo_local" id="equipoLocal" name="equipoLocal" placeholder="Selecciones un equipo local" s2-options="equipo.id as (equipo.codigo+' - '+equipo.nombre) for equipo in equiposList" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.equipoVisita.$valid }">
						<label class="control-label col-md-3" for="equipoVisita">
							Equipo visita
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartido.equipo_visita" id="equipoVisita" name="equipoVisita" placeholder="Selecciones un equipo visita" s2-options="equipo.id as (equipo.codigo+' - '+equipo.nombre) for equipo in equiposList track by equipo.id" required>
								<option value=""></option>
							</select2>	
						</div>					
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.campeonato.$valid }">
						<label class="control-label col-md-3" for="campeonato">
							Campeonato
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartido.campeonato_id" id="campeonato" name="campeonato" placeholder="Selecciones el campeonato" s2-options="campeonato.id as (campeonato.codigo+' - '+campeonato.nombre) for campeonato in campeonatosList track by campeonato.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.fechaTorneo.$valid }">
						<label for="fechaTorneo" class="col-md-3 control-label baja">Fecha torneo</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="fechaTorneo" name="fechaTorneo" ng-model="formulario.CatalogacionPartido.fecha_torneo" placeholder="Ingrese fecha torneo" required>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.fecha_partido.$valid }">
						<label for="numero" class="col-md-3 control-label baja">Fecha partido</label>
						<div class="col-md-9">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background" readonly="readonly" id="fecha_partido" name="fecha_partido" ng-model="fecha_partido" placeholder="Seleccione fecha partido" required>	
							</div>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !ingestasAddForm.observacion.$valid }">
						<label for="numero" class="col-md-3 control-label baja">Observación</label>
						<div class="col-md-9">
							<textarea class="form-control" rows="5" id="observacion" name="observacion" ng-model="formulario.CatalogacionPartido.observacion" placeholder="Ingrese observación"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="!ingestasAddForm.$valid || editando" ng-click="editarCatalogacionPartido()"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
							<a href="<?php echo $this->request->referer(); ?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"> Volver</i></a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/catalogacion_partidos/catalogacion_partidos",
		"angularjs/servicios/equipos/equipos",
		"angularjs/servicios/campeonatos/campeonatos",
		"angularjs/controladores/catalogacion_partidos/catalogacion_partidos",
		"angularjs/modulos/select2/angular-select2.min",
		'bootstrap-datepicker',
		"select2.min"
		)); 
?>