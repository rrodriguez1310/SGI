<div ng-controller="codigosPresupuestosAdd" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="detalle">
		<div class="row">
			<div class="col-md-12 text-center">
				<h4>Ingresar Codigo Presupuestario</h4>
			</div>
		</div>
		<br/>
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" name="codigosPresupuestoEdit" novalidate>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.year.$valid }">
						<label class="col-md-4 control-label" for="year">Año</label>
						<div class="col-md-5">
							<ui-select ng-model="formulario.CodigosPresupuesto.year_id" id="year" name="year" required>
								<ui-select-match placeholder="Seleccione un año" allow-clear="true">
									{{$select.selected.nombre }}
								</ui-select-match>
								<ui-select-choices repeat="year.id as year in yearsList | filter: $select.search">
									<div ng-bind-html="(year.nombre | uppercase ) | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.nombre.$valid }">
						<label class="col-md-4 control-label baja" for="nombre">Nombre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="nombre" id="nombre" required maxlength="100" ng-model="formulario.CodigosPresupuesto.nombre">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.codigo.$valid }">
						<label class="col-md-4 control-label baja" for="codigo">Codigo</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="codigo" id="codigo" required maxlength="20" ng-model="formulario.CodigosPresupuesto.codigo">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.total.$valid }">
						<label class="col-md-4 control-label baja" for="total">Total</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="total" id="total" required solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_total">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.enero.$valid }">
						<label class="col-md-4 control-label baja" for="enero">Enero</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="enero" id="enero" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_enero">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.febrero.$valid }">
						<label class="col-md-4 control-label baja" for="febrero">Febrero</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="febrero" id="febrero" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_febrero">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.marzo.$valid }">
						<label class="col-md-4 control-label baja" for="marzo">Marzo</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="marzo" id="marzo" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_marzo">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.abril.$valid }">
						<label class="col-md-4 control-label baja" for="abril">Abril</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="abril" id="abril" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_abril">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.mayo.$valid }">
						<label class="col-md-4 control-label baja" for="mayo">Mayo</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="mayo" id="mayo" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_mayo">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.junio.$valid }">
						<label class="col-md-4 control-label baja" for="junio">Junio</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="junio" id="junio" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_junio">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.julio.$valid }">
						<label class="col-md-4 control-label baja" for="julio">Julio</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="julio" id="julio" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_julio">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.agosto.$valid }">
						<label class="col-md-4 control-label baja" for="agosto">Agosto</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="agosto" id="agosto" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_agosto">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.septiembre.$valid }">
						<label class="col-md-4 control-label baja" for="septiembre">Septiembre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="septiembre" id="septiembre" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_septiembre">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.octubre.$valid }">
						<label class="col-md-4 control-label baja" for="octubre">Octubre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="octubre" id="octubre" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_octubre">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.noviembre.$valid }">
						<label class="col-md-4 control-label baja" for="noviembre">Noviembre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="noviembre" id="noviembre" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_noviembre">
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestoEdit.diciembre.$valid }">
						<label class="col-md-4 control-label baja" for="diciembre">Diciembre</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="diciembre" id="diciembre" solo-numeros ng-model="formulario.CodigosPresupuesto.presupuesto_diciembre">
						</div>
					</div>
					<br/>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-disabled="!codigosPresupuestoEdit.$valid" ng-click="ingresarCodigoPresupuesto()"><i class="fa fa-pencil"></i> Registrar</button>
							<a id="volver" class="volver btn btn-default btn-lg" ng-href="<?php echo $this->request->referer(); ?>"><i class="fa fa-mail-reply-all"></i> Volver</a>
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
		"angularjs/directivas/solo_numeros.js",
		"angularjs/servicios/codigos_presupuestos/codigos_presupuestos",
		"angularjs/servicios/years/years",
		"angularjs/controladores/codigos_presupuestos/codigos_presupuestos"
		)
	);
?>