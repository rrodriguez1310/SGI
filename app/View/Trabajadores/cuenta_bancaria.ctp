<div ng-controller="trabajadoresCuentaBancaria" ng-init="trabajadoreId = <?php echo $id; ?>" ng-cloak >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="cuentaBancariaShow">
		<div class="row text-center">
			<h4>Cuenta Bancaria {{ nombre }}</h4>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<form class="form-horizontal" name="formularioCuentaBancaria" novalidate>
					<input type="hidden" ng-model="formulario.Trabajadore.id">
					<input type="hidden" ng-model="formulario.CuentasCorriente.id">
					<input type="hidden" ng-model="formulario.CuentasCorriente.tipo">
					<div class="form-group" ng-class="{ 'has-error': !formularioCuentaBancaria.banco.$valid }">
						<label class="col-md-3 control-label">Banco</label>
						<div class="col-md-8">
							<ui-select name="banco" ng-model="formulario.CuentasCorriente.banco_id" required>
								<ui-select-match placeholder="Seleccione un banco">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="bancos.id as bancos in bancosList | filter: $select.search">
									<div ng-bind-html="bancos.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formularioCuentaBancaria.tipo_cuenta.$valid }">
						<label class="col-md-3 control-label">Tipo Cuenta</label>
						<div class="col-md-8">
							<ui-select name="tipo_cuenta" ng-model="formulario.CuentasCorriente.tipos_cuenta_banco_id" required>
								<ui-select-match placeholder="Seleccione un tipo de cuenta">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="tiposCuentaBancos.id as tiposCuentaBancos in tiposCuentaBancosList | filter: $select.search">
									<div ng-bind-html="tiposCuentaBancos.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !formularioCuentaBancaria.cuenta.$valid }">
						<label class="col-md-3 control-label baja">N° Cuenta</label>
						<div class="col-md-8">
							<input class="form-control" type="text" name="cuenta" ng-model="formulario.CuentasCorriente.cuenta" required>
						</div>
					</div>
					<br/>
					<div class="form-group text-center">
						<button class="btn btn-primary btn-lg" ng-disabled="!formularioCuentaBancaria.$valid" ng-click="guardarCuenta()"><i class="fa fa-pencil-square-o"></i> Guardar</button>
						<button class="btn btn-default btn-lg" ng-click="volver()"><i class="fa fa-mail-reply-all"></i> Volver</button>
					</div>
				</form>			
			</div>
		</div>	
	</div>
</div>
<?php
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/trabajadores',
		'angularjs/servicios/servicios',
		'angularjs/servicios/trabajadores'
		));
?>