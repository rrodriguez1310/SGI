<div ng-controller="cargosAdd" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="cargosShow">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4>Registrar Cargo</h4>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="cargosAdd" novalidate>
					<input type="hidden" ng-model="formulario.Cargo.estado" ng-init="formulario.Cargo.estado = 1">
					<div class="form-group"  ng-class="{ 'has-error': !cargosAdd.cargosFamilias.$valid }">
						<label class="col-md-3 control-label" for="cargosFamilias">Familia</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.cargos_familia_id" id="cargosFamilias" name="cargosFamilias" required>
								<ui-select-match placeholder="Seleccione una familia">
									{{$select.selected.nombre | uppercase}}
								</ui-select-match>
								<ui-select-choices repeat="cargosFamilia.id as cargosFamilia in cargosFamiliasList | filter: $select.search">
									<div ng-bind-html="(cargosFamilia.nombre | uppercase) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosAdd.cargosNivelResponsabilidad.$valid }">
						<label class="col-md-3 control-label" for="cargosNivelResponsabilidad">Nivel Responsabilidad</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.cargos_nivel_responsabilidade_id" id="cargosNivelResponsabilidad" name="cargosNivelResponsabilidad" required>
								<ui-select-match placeholder="Seleccione un nivel de responsabilidad">
									{{$select.selected.nivel}}
								</ui-select-match>
								<ui-select-choices repeat="cargosNivelResponsabilidad.id as cargosNivelResponsabilidad in cargosNivelResponsabilidadesList | filter: $select.search">
									<div ng-bind-html="cargosNivelResponsabilidad.nivel | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosAdd.gerencia.$valid }">
						<label class="col-md-3 control-label" for="gerencia">Gerencia</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Gerencias.gerencia_id" id="gerencia" name="gerencia" on-select="cambioGerencia($item)" required>
								<ui-select-match placeholder="Seleccione una gerencia">
									{{$select.selected.nombre | uppercase}}
								</ui-select-match>
								<ui-select-choices repeat="gerencias.id as gerencias in gerenciasList | filter: $select.search">
									<div ng-bind-html="(gerencias.nombre) | uppercase | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosAdd.area.$valid }">
						<label class="col-md-3 control-label" for="area">Área</label>
						<div class="col-md-9">
							<ui-select ng-model="formulario.Cargo.area_id" id="area" name="area" required>
								<ui-select-match placeholder="Seleccione un área">
									{{$select.selected.nombre | uppercase}}
								</ui-select-match>
								<ui-select-choices repeat="areas.id as areas in areasList | filter: $select.search">
									<div ng-bind-html="(areas.nombre | uppercase) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !cargosAdd.cargo.$valid }">
						<label class="col-md-3 control-label baja" for="cargo">Cargo</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="cargo" id="cargo" ng-model="formulario.Cargo.nombre" ng-change="refreshData(formulario.Cargo.nombre)" required>	
						</div>
						
					</div>



					<!--form class="form-horizontal" name="documentosAdd" novalidate-->

						<div class="form-group">
							<label class="col-md-4 control-label baja">Adjuntar descripcón de cargo</label>
							<div class="col-md-8">
								<input ngf-select ng-model="formulario.File.descripcion" name="file" type="file" accept=".docx,.doc" required>
							</div>
						</div>


						<!--div class="form-group text-center">
							<button ng-disabled="!documentosAdd.$valid" ng-click="uploadDescripcion()" class="btn btn-success"><i class="fa fa-upload"></i></i> Agregar</button>
						</div-->
					<!--/form-->



					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="!cargosAdd.$valid" ng-click="registrarCargo()"><i class="fa fa-pencil"></i> Registrar</button>
							<a id="volver" class="volver btn btn-default btn-lg" ng-href="{{ host }}cargos"><i class="fa fa-mail-reply-all"></i> Volver</a>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div ng-show="resultadosShow">
				<div class="col-md-12 text-center">
					<h4>Listado de cargos encontrados</h4>
				</div>
				<div class="col-md-12">
					<div ui-grid="gridOptions" ui-grid-exporter ng-model="grid" class=""></div>	
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/cargos/cargos",
		"angularjs/servicios/areas/areas",
		"angularjs/servicios/gerencias/gerencias",
		"angularjs/servicios/cargos_familias/cargos_familias",
		"angularjs/servicios/cargos_nivel_responsabilidades/cargos_nivel_responsabilidades",
		"angularjs/factorias/areas/areas",
		"angularjs/controladores/cargos/cargos"
		)); 
?>		
</script>
