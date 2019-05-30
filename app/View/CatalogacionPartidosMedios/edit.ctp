<div ng-controller="catalogacionPartidosMediosEdit" ng-cloak ng-init="idCatalogacionPartidosMedio(<?php echo $this->request->pass[0]; ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="cargado">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4>Editar medio</h4>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form class="form-horizontal" name="formCatalogacionMediosEdit" novalidate>
					<div class="form-group">
						<label class="control-label col-md-3 baja" for="codigo">
							Codigo
						</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="codigo" name="codigo" ng-model="formulario.CatalogacionPartidosMedio.codigo" disabled="disabled">	
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 baja" for="numero">
							Numero
						</label>
						<div class="col-md-9">
							<input type="text" class="form-control" id="numero" name="numero" ng-model="formulario.CatalogacionPartidosMedio.numero">	
						</div>
					</div>
					<div class="form-group"  ng-class="{ 'has-error': !formCatalogacionMediosEdit.fechaIngreso.$valid }">
						<label class="control-label col-md-3 baja" for="fechaIngreso">
							Fecha Ingreso
						</label>
						<div class="col-md-9">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background" id="fechaIngreso" name="fechaIngreso" ng-model="fecha_ingreso" required>		
							</div>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.formato.$valid }">
						<label class="control-label col-md-3" for="formato">
							Formato
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartidosMedio.formato_id" id="formato" name="formato" placeholder="Seleccione un formato" s2-options="formato.id as formato.nombre for formato in formatosList track by formato.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.bloque.$valid }">
						<label class="control-label col-md-3" for="bloque">
							Bloque
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartidosMedio.bloque_id" id="bloque" name="bloque" placeholder="Seleccione un bloque" s2-options="bloque.id as (bloque.codigo + ' - ' + bloque.nombre) for bloque in bloquesList track by bloque.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.soporte.$valid }">
						<label class="control-label col-md-3" for="bloque">
							Soporte
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartidosMedio.soporte_id" id="soporte" name="soporte" placeholder="Seleccione un soporte" s2-options="soporte.id as soporte.nombre for soporte in soportesList track by soporte.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.almacenamiento.$valid }">
						<label class="control-label col-md-3" for="bloque">
							Almacenamiento
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartidosMedio.almacenamiento_id" id="almacenamiento" name="almacenamiento" placeholder="Seleccione un almacenamiento" s2-options="almacenamiento.id as almacenamiento.lugar for almacenamiento in almacenamientosList track by almacenamiento.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.copia.$valid }">
						<label class="control-label col-md-3" for="copia">
							Copias
						</label>
						<div class="col-md-9">
							<select2 class="form-control" ng-model="formulario.CatalogacionPartidosMedio.copia_id" id="copia" name="copia" placeholder="Seleccione una copia" s2-options="copia.id as copia.copia for copia in copiasList track by copia.id" required>
								<option value=""></option>
							</select2>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formCatalogacionMediosEdit.observacion.$valid }">
						<label for="observacion" class="col-md-3 control-label baja">Observación</label>
						<div class="col-md-9">
							<textarea class="form-control" rows="5" id="observacion" name="observacion" ng-model="formulario.CatalogacionPartidosMedio.observacion" placeholder="Ingrese observación"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="!formCatalogacionMediosEdit.$valid || editando" ng-click="editarCatalogacionPartidosMedios()"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"catalogacion_partidos", "action"=>"view", $catalogacionPartidoId), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
						</div>
					</div>
				</form>	
			</div>
		</div>
	</div>
	
</div>
<?php 
	echo $this->Html->script(array(
		"angularjs/controladores/app.js",
		"angularjs/servicios/catalogacion_partidos_medios/catalogacion_partidos_medios",
		"angularjs/servicios/formatos/formatos",
		"angularjs/servicios/bloques/bloques",
		"angularjs/servicios/soportes/soportes",
		"angularjs/servicios/almacenamientos/almacenamientos",
		"angularjs/servicios/copias/copias",
		"angularjs/servicios/catalogacion_partidos/catalogacion_partidos",
		"angularjs/factorias/formatos/formatos",
		"angularjs/factorias/bloques/bloques",
		"angularjs/factorias/soportes/soportes",
		"angularjs/factorias/almacenamientos/almacenamientos",
		"angularjs/factorias/copias/copias",
		"angularjs/controladores/catalogacion_partidos_medios/catalogacion_partidos_medios",
		'bootstrap-datepicker',
		"select2.min"
		)
	);
?>