
<div ng-controller="sistemasIncidenciasAdd" ng-cloak ng-init="usuarioId(<?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Ingreso Incidencias</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="sistemasIncidenciasAddForm" novalidate>
					<div class="form-group" ng-class="{ 'has-error': (sistemasIncidenciasAddForm.inicioFecha.$invalid || sistemasIncidenciasAddForm.hora_inicio.$invalid) ? true : false }">
						<label class="control-label col-md-3 baja" for="inicio">Inicio fecha</label>
						<div class="col-md-4">
							<div class="input">
								<input ng-model="fecha_inicio" name="inicioFecha" id="inicioFecha" class="form-control datepicker readonly-pointer-background" readonly="readonly" required placeholder="Seleccione fecha inicio" />
							</div>
						</div>
						<label for="hora_inicio" class="col-md-2 control-label baja">Inicio hora</label>
						<div class="col-md-3">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background clockpicker" name="hora_inicio" id="hora_inicio" ng-model="formulario.SistemasIncidencia.hora_inicio" required readonly placeholder="Selecciona hora inicio" />	
							</div>
						</div>
					</div>
					
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasAddForm.responsable.$invalid }">
						<label class="control-label col-md-3" for="gerencia">Responsable</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="responsable" id="responsableId" ng-options="responsable.id as responsable.nombre for responsable in responsablesList track by responsable.id" ng-model="formulario.SistemasIncidencia.sistemas_responsables_incidencia_id" ng-change="cambiaResponsable()"placeholder="Seleccione un responsable"  required ng-readonly="responsableReadOnly">
								<option></option>
							</select>	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasAddForm.gerencia.$invalid }">
						<label class="control-label col-md-3" for="gerencia">Gerencia</label>
						<div class="col-md-9">
							<input type="text" class="form-control mayuscula " name="gerencia" id="gerencia" ng-model="formulario.SistemasIncidencia.gerencia"  required />	
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasAddForm.areas.$invalid }">
						<label class="control-label col-md-3" for="areas">Área</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="areas" id="areas" ng-change="buscaTrabajadoresArea()" ng-options="area.id as (area.nombre | uppercase) for area in areasList | orderBy: 'nombre' " ng-model="formulario.SistemasIncidencia.area_id" placeholder="Seleccione un area" required>
								<option value=""></option>
							</select>	
						</div>
					</div>
					<div ng-show="hola"class="form-group">
						<label class="control-label col-md-3" for="areas">Trabajador</label>
						<div class="col-md-9">
							<select type="text" class="form-control select2" name="trabajador" id="trabajador" ng-options="trabajador.id as (trabajador.nombre | uppercase) for trabajador in trabajadoresList | orderBy : 'nombre'" ng-model="formulario.SistemasIncidencia.trabajadore_id" placeholder="Seleccione un trabajadore">
								<option value=""></option>
							</select>	
						</div>
					</div>
					
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasAddForm.titulo.$invalid }">
						<label class="control-label col-md-3 baja" for="titulo">Tarea / Problema</label>
						<div class="col-md-9">
							<input class="form-control" ng-model="formulario.SistemasIncidencia.titulo" name="titulo" id="titulo" ng-minlength="6" ng-maxlength="50" placeholder="Minimo 6 carateres y maximo 20" required maxlength="50" />
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasAddForm.tarea.$invalid }">
						<label class="control-label col-md-3" for="tarea">Detalle Tarea / Problema</label>
						<div class="col-md-9">
							<textarea class="form-control" name="tarea" id="tarea" ng-model="formulario.SistemasIncidencia.tarea" rows="5" ng-minlength="6" required placeholder="Minimo 6 caracteres">
							</textarea>	
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="sistemasIncidenciasAddForm.$invalid || registrando" ng-click="registrarIncidencia()"><i class="fa fa-pencil"></i> Registrar</button>
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
