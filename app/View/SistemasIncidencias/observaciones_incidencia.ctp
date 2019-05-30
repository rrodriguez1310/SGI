<div ng-controller="sistemasIncidenciasObservacionesIncidencia" ng-cloak ng-init="incidenciaid(<?php echo $this->request->pass[0];?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Observacion Incidencia</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form name="sistemasIncidenciasObservacionesForm" novalidate>
					<div class="form-group" ng-class="{ 'has-error': sistemasIncidenciasObservacionesForm.observacion.$invalid }">
						<label class="control-label" for="cierre">Observacion</label>
						<textarea class="form-control" ng-model="formulario.SistemasIncidenciasOb.observacion" name="observacion" id="observacion" rows="8" placeholder="Minimo 6 caracteres" ng-minlength="6" required></textarea>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<a href="" class="btn btn-primary btn-lg" ng-disabled="sistemasIncidenciasObservacionesForm.$invalid || registrando" ng-click="registrarObservacion()"><i class="fa fa-pencil"></i> Registrar</a>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_incidencias", "action"=>"index"), array("class"=>"btn btn-default btn-lg baja", "escape"=>false)); ?>
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
	"angularjs/servicios/sistemas_incidencias/sistemas_incidencias",
	"angularjs/controladores/sistemas_incidencias/sistemas_incidencias",
));
?>