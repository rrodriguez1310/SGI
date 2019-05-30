<div ng-controller="sistemasIncidenciasEdit" ng-cloak ng-init="parametros(<?php echo $this->Session->Read("PerfilUsuario.idUsuario");?>,<?php echo $this->request->pass[0];?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Ingreso Incidencia</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="sistemasIncidenciaEditForm" novalidate>
					<div class="form-group" ng-class="{ 'has-error': (sistemasIncidenciaEditForm.fecha_inicio.$invalid || sistemasIncidenciaEditForm.inicioHora.$invalid) ? true : false }">
						<label class="control-label col-md-3 baja" for="inicio">Inicio fecha</label>
						<div class="col-md-4">
							<div class="input">
								<input ng-model="formulario.SistemasIncidencia.fecha_inicio" name="fecha_inicio" id="fecha_inicio" class="form-control datepicker readonly-pointer-background" readonly="readonly" required placeholder="Seleccione fecha inicio" />
							</div>
						</div>
						<label for="hora_inicio" class="col-md-2 control-label baja">Inicio hora</label>
						<div class="col-md-3">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background clockpicker" name="hora_inicio" id="formulario.SistemasIncidencia.hora_inicio" ng-model="hora_inicio" required readonly placeholder="Selecciona hora inicio" />	
							</div>
						</div>
					</div>
				
					
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciaEditForm.responsable.$invalid }">
						<label class="control-label col-md-3" for="gerencia">Responsable</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="responsable" id="responsableId" ng-options="responsable.id as responsable.nombre for responsable in responsablesList track by responsable.id" ng-change="cambiaResponsable()"ng-model="formulario.SistemasIncidencia.sistemas_responsables_incidencia_id" placeholder="Seleccione un responsable"  required ng-readonly="responsableReadOnly">
								<option></option>
							</select>	
						</div>
					</div>
					
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciaEditForm.gerencia.$invalid }">
						<label class="control-label col-md-3" for="gerencia">Gerencia</label>
						<div class="col-md-9">
							<select type="text" class="form-control mayuscula select2" name="gerencia" id="gerencia"  readonly="readonly" ng-model="gerencia" placeholder="Seleccione un gerencia" ng-change="cambiaGerencia()" required>
								<option></option>
							</select>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciaEditForm.areas.$invalid }">
						<label class="control-label col-md-3" for="areas">Área</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="areas" id="areas" ng-change="buscaTrabajadoresArea(true)" ng-options="area.id as (area.nombre | uppercase) for area in areasList | orderBy: 'nombre'" ng-model="formulario.SistemasIncidencia.area_id" placeholder="Seleccione un área" required>
								<option value=""></option>
							</select>	
						</div>
					</div>
					<div ng-show="hola" class="form-group">
						<label class="control-label col-md-3" for="areas">Trabajador</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="trabajador" id="trabajador" ng-options="trabajador.id as (trabajador.nombre | uppercase) for trabajador in trabajadoresList | orderBy : 'nombre'" ng-model="formulario.SistemasIncidencia.trabajadore_id" placeholder="Seleccione un trabajadore">
								<option value=""></option>
							</select>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciaEditForm.titulo.$invalid }">
						<label class="control-label col-md-3 baja" for="titulo">Titulo</label>
						<div class="col-md-9">
							<input class="form-control" ng-model="formulario.SistemasIncidencia.titulo" name="titulo" id="titulo" ng-minlength="6" ng-maxlength="50" placeholder="Minimo 6 carateres y maximo 20" required maxlength="50" />
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciaEditForm.observacionIngreso.$invalid }">
						<label class="control-label col-md-3" for="observacionIngreso">Tarea / Problema</label>
						<div class="col-md-9">
							<textarea class="form-control" name="observacionIngreso" id="observacionIngreso" ng-model="formulario.SistemasIncidencia.tarea" rows="5" ng-minlength="6" required placeholder="Minimo 6 caracteres">
							</textarea>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="sistemasIncidenciaEditForm.$invalid || registrando" ng-click="registrarIncidencia()"><i class="fa fa-pencil-square-o"></i> Actualizar</button>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_incidencias", "action"=>"index"), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>	
</div>
<?php
echo $this->Html->css("bootstrap-clockpicker.min");
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/filtros/filtros",
	"angularjs/servicios/sistemas_incidencias/sistemas_incidencias",
	"angularjs/servicios/areas/areas",
	"angularjs/servicios/gerencias/gerencias",
	"angularjs/servicios/users/lista_users_service",
	"angularjs/servicios/sistemas_responsables_incidencias/sistemas_responsables_incidencias",
	"angularjs/servicios/trabajadores",
 	"angularjs/factorias/users/users",
 	"angularjs/factorias/factoria",
	"angularjs/controladores/sistemas_incidencias/sistemas_incidencias",
	"select2.min",
	'bootstrap-datepicker',
 	"bootstrap-clockpicker.min"
)); 
?>
<script type="text/javascript">
	$(".select2").select2({
		allowClear: true,
		width:'100%',
		minimumInputLength: -1
	});
</script>
