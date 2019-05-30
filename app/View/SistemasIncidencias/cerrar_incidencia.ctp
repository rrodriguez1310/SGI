<div ng-controller="sistemasIncidenciasCerrarIncidencia" ng-cloak ng-init="incidenciaid(<?php echo $this->request->pass[0];?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Cierre Incidencia</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form name="sistemasIncidenciasCierreForm" class="form-horizontal" novalidate>
					<div class="form-group" ng-class="{ 'has-error': (sistemasIncidenciasCierreForm.cierre_fecha.$invalid || sistemasIncidenciasCierreForm.cierre_fecha.$invalid) ? true : false }">
						<label class="control-label col-md-3 baja" for="inicio">Fecha cierre</label>
						<div class="col-md-4">
							<div class="input">
								<input ng-model="cierre_fecha" name="cierre_fecha" id="cierre_fecha" class="form-control datepicker readonly-pointer-background" readonly="readonly" required placeholder="Seleccione fecha de cierre" />
							</div>
						</div>
						<label for="inicioHora" class="col-md-2 control-label baja">Hora cierre</label>
						<div class="col-md-3">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background clockpicker" name="hora_cierre" id="hora_cierre" ng-model="hora_cierre" required readonly placeholder="Selecciona hora de cierre" />	
							</div>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasCierreForm.cierre.$invalid }">
						<label class="control-label" for="cierre">Cierre</label>
						<textarea class="form-control" ng-model="formulario.SistemasIncidencia.observacion_termino" name="cierre" id="cierre" rows="8" placeholder="Minimo 6 caracteres" ng-minlength="6" required></textarea>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<a href="" class="btn btn-primary btn-lg" ng-disabled="sistemasIncidenciasCierreForm.$invalid || registrando" ng-click="cerraIncidencia()"><i class="fa fa-pencil"></i> Registrar</a>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_incidencias", "action"=>"index"), array("class"=>"btn btn-default btn-lg", "escape"=>false)); ?>
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
	"angularjs/servicios/sistemas_incidencias/sistemas_incidencias",
	"angularjs/controladores/sistemas_incidencias/sistemas_incidencias",
	'bootstrap-datepicker',
	"bootstrap-clockpicker.min"
));
?>