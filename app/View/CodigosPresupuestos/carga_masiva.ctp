<?php  ;?>
<div ng-controller="codigosPresupuestosCargaMasiva" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="detalle">
		<div class="row">
			<div class="col-md-8 col-md-offset-2 text-center">
				<h4>Carga masiva de codigos presupuestarios</h4>
			</div>
			<div class="col-md-2">
				<a href="<?php echo  $this->webroot."files".DS."codigos_presupuestos".DS."carga_masiva_codigos_presupuestarios_formato.csv"; ?>" class="btn btn-warning tool" data-toggle="tooltip" data-placement="bottom" title="Descarga formato obligatorio para carga masiva" download><i class="fa fa-download"></i> Formato</a>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">
				<form class="form-horizontal" name="codigosPresupuestariosCargaMasiva" novalidate>
					<div class="form-group" ng-class="{ 'has-error': !codigosPresupuestariosCargaMasiva.year.$valid }">
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
					<div class="form-group"  ng-class="{ 'has-error': !codigosPresupuestariosCargaMasiva.file.$valid }">
						<label class="col-md-4 control-label baja">Archivo</label>
						<div class="col-md-5">
							<input type="file" ngf-select type="file" name="file" ng-model="formulario.CodigosPresupuesto.archivo" ng-required="true" accept=".csv">	
						</div>
					</div>
					<br />
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button class="btn btn-primary btn-lg" ng-click="subirArchivo()" ng-disabled="!codigosPresupuestariosCargaMasiva.$valid || procesando"><i class="fa fa-upload"></i> Subir</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-info">
				<h5>Instrucciones</h5>
				<ol>
					<li>Descargue el formato en la parte superior</li>
					<li>Llene los datos según la cabecera de columnas del formato</li>
					<li>Seleccione el año que desea cargar</li>
					<li>Seleccione el archivo con la información cargada</li>
					<li>Presione el boton subir para iniciar la carga</li>
				</ol>
				<h5>Consideraciones</h5>
				<ol>
					<li>No altere la estructura de columnas del formato</li>
					<li>Los codigos presupuestarios en el año no se pueden repetir</li>
					<li>Nombre, codigo y total son obligatorios</li>
					<li>Los valores ingresados en total y meses son enteros sin puntos ni comas</li>
					<li>El total en 0 sera considerado como no ingresado</li>
					<li>Si se despliega la tabla "Errores en archivo carga masiva", por favor corrige lo mencionado e intente nuevamente</li>
				</ol>
			</div>
		</div>
		<div ng-show="detalleErrores">
			<div class="row">
				<div class="col-md-12">
					<table class="table table-condensed table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" colspan="2"><H5>Errores en archivo carga masiva</H5></th>
							</tr>
							<tr>
								<th class="text-center">Linea Error</th>
								<th class="text-center">Errores</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="valores in errores">
								<td>{{ valores.fila }}</td>
								<td>
									<ul>
										<li ng-repeat="error in valores.errores">{{ error }}</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	echo $this->Html->script(array(
		"angularjs/controladores/app",
		"angularjs/servicios/codigos_presupuestos/codigos_presupuestos",
		"angularjs/servicios/years/years",
		"angularjs/controladores/codigos_presupuestos/codigos_presupuestos"
		));
?>