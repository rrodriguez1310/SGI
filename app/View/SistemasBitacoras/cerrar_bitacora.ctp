<div ng-controller="sistemasBitacorasCerrarBitacora" ng-cloak ng-init="bitacoraid(<?php echo $this->request->pass[0];?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Cierre Bitacora</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form name="sistemasBitacorasCierreForm" class="form-horizontal" novalidate>
					<div class="form-group" ng-class="{ 'has-error': (sistemasBitacorasCierreForm.cierreFecha.$invalid || sistemasBitacorasCierreForm.cierreHora.$invalid) ? true : false }">
						<label class="control-label col-md-3 baja" for="inicio">Fecha cierre</label>
						<div class="col-md-4">
							<div class="input">
								<input ng-model="cierre_fecha" name="cierreFecha" id="cierreFecha" class="form-control datepicker readonly-pointer-background" readonly="readonly" required placeholder="Seleccione fecha de cierre" />
							</div>
						</div>
						<label for="inicioHora" class="col-md-2 control-label baja">Hora cierre</label>
						<div class="col-md-3">
							<div class="input">
								<input type="text" class="form-control readonly-pointer-background clockpicker" name="cierreHora" id="cierreHora" ng-model="cierre_hora" required readonly placeholder="Selecciona hora de cierre" />	
							</div>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': sistemasBitacorasCierreForm.cierre.$invalid }">
						<label class="control-label" for="cierre">Cierre</label>
						<textarea class="form-control" ng-model="formulario.SistemasBitacora.observacion_termino" name="cierre" id="cierre" rows="8" placeholder="Minimo 6 caracteres" ng-minlength="6" required></textarea>
					</div>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<a href="" class="btn btn-primary btn-lg" ng-disabled="sistemasBitacorasCierreForm.$invalid || registrando" ng-click="cerraBitacora()"><i class="fa fa-pencil"></i> Registrar</a>
							<?php echo $this->Html->link('<i class="fa fa-mail-reply-all"></i> Volver</a>', array("controller"=>"sistemas_bitacoras", "action"=>"index"), array("class"=>"btn btn-default btn-lg", "escape"=>false)); ?>
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
	"angularjs/servicios/sistemas_bitacoras/sistemas_bitacoras",
	"angularjs/controladores/sistemas_bitacoras/sistemas_bitacoras",
	'bootstrap-datepicker',
	"bootstrap-clockpicker.min"
));
?>