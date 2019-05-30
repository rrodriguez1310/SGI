<div ng-controller="imprimirContrato" ng-init="idTrabajador(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="detalle">
		<div class="col-md-8 col-md-offset-2">
			<form class="form-horizontal" name="formulario" ng-submit="formImprimirContrato(form)" novalidate>
				<input type="hidden" ng-model="form.tipo_contrato_id">
				<div class="form-group" ng-class="{'has-error':!formulario.plantilla.$valid }">
					<label for="inputEmail3" class="col-md-3 control-label">Plantilla</label>
					<div class="col-md-7">
						<select class="select2" name="plantilla" ng-model="form.tipos_documento_id" required placeholder="Seleccione una plantilla" ng-options="tipoContrato.TiposDocumento.id as tipoContrato.TiposDocumento.nombre | uppercase for (k, tipoContrato) in tipoContratos" ng-change="changeSelect()" required>
							<option value=""></option>
						</select>
					</div>
				</div>
				<div ng-show="inputContratoOrigen">
					<div class="form-group" ng-class="{'has-error':!formulario.contratoOrigen.$valid }">
						<label for="contratoOrigen" class="col-md-3 control-label">Contrato Origen</label>
						<div class="col-md-7">
							<select class="select2" ng-model="contratoOrigen" id="contratoOrigen" name="contratoOrigen" placeholder="Seleccione un contrato de origen" ng-options="documento.Documento.fecha_inicial as (documento.Documento.fecha_inicial | date : 'dd/MM/yyyy')+' - '+(documento.TiposDocumento.nombre | uppercase) for (k, documento) in documentos" ng-required="inputContratoOrigen">
								<option value=""></option>
							</select>
						</div>
					</div>
				</div>
				<div ng-show="inputUbicacion">
					<div class="form-group" ng-class="{'has-error':!formulario.ubicacion.$valid }">
						<label for="sueldo" class="col-md-3 control-label">Ubicación</label>
						<div class="col-md-7">
							<select class="select2" ng-model="ubicacion_empresa" id="ubicacion" name="ubicacion" placeholder="Selecciones una dirección" ng-options="direccion.direccion as direccion.direccion for (k, direccion) in direcciones" ng-required="inputUbicacion">
								<option value=""></option>
							</select>
						</div>
					</div>
				</div>
				<div ng-show="inputFecha1Show">
					<div class="form-group" ng-class="{'has-error':!formulario.inputFechaVigencia.$valid }">
						<label for="inputFechaVigencia" class="col-md-3 control-label baja">Fecha Vigencia</label>
						<div class="col-md-7">
							<div class="input">
								<input type="text" readonly="readonly" name="inputFechaVigencia" class="fecha form-control readonly-pointer-background" ng-model="inputFechaVigencia" ng-required="inputFecha1Show">									
							</div>
						</div>
					</div>
				</div>
				<div ng-show="inputSueldo">
					<div class="form-group" ng-class="{'has-error':!formulario.sueldo.$valid }">
						<label for="sueldo" class="col-md-3 control-label baja">Sueldo</label>
						<div class="col-md-7">
							<input type="number" name="sueldo" id="sueldo" ng-model="sueldo" class="form-control" ng-change="numeroPalabras()" solo-numeros ng-required="inputSueldo">
						</div>
					</div>
				</div>
				<div ng-show="inputMes">
					<div class="form-group" ng-class="{'has-error':!formulario.mes.$valid }">
						<label for="ingresaMes" class="col-md-3 control-label baja">Mes</label>
						<div class="col-md-7">
							<input type="text" required name="mes" ng-model="mes" class="form-control" ng-change="sumaMes(mes)" ng-required="inputMes">
						</div>
					</div>
				</div>
				<div ng-show="inputCargo">
					<div class="form-group" ng-class="{'has-error':!formulario.cargo.$valid }">
						<label for="cargo" class="col-md-3 control-label baja">Cargo</label>
						<div class="col-md-7">
							<input type="text" name="cargo"  ng-model="cargo" class="form-control" readonly="readonly" ng-required="inputCargo">
						</div>
					</div>
				</div>
				<div ng-show="inputRepresentanteLegal">
					<div class="form-group" ng-class="{'has-error':!formulario.representanteLegal.$valid }">
						<label for="representanteLegal" class="col-md-3 control-label">Representante Legal</label>
						<div class="col-md-7">
							<select class="select2" ng-model="representanteLegal" id="representanteLegal" name="representanteLegal" placeholder="Selecciones un representante Legal" ng-options="representanteLegal.nombre for representanteLegal in representantesLegales" ng-required="inputRepresentanteLegal">
								<option value=""></option>
							</select>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div ng-show="form.tipos_documento_id">
		<br/>
		<div class="row">
			<div class="col-md-12" compile="plantilla" id="plantilla">
					
			</div>
		</div>
		<br/>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<button class="btn btn-primary btn-lg" ng-show="form.tipos_documento_id" ng-disabled="!formulario.$valid" ng-click="imprimirPlantilla()"><i class="fa fa-file-pdf-o fa-lg "></i> Exportar PDF</button>
			<a href="<?php echo $this->request->referer()?>" ng-show="detalle" class="btn btn-default volver btn-lg"><i class="fa fa-mail-reply-all"> Volver</i></a>
		</div>
	</div>
</div>
<?php echo $this->Html->script(array(
	'angularjs/controladores/app', 
	'angularjs/controladores/trabajadores',
	'angularjs/servicios/servicios',
	'angularjs/servicios/localizaciones/localizaciones',
	'angularjs/servicios/documentos/documentos',
	'angularjs/servicios/trabajadores',
	'angularjs/servicios/tipo_contratos_plantillas/tipo_contratos_plantillas',
	'angularjs/factorias/tipo_contratos_plantillas/tipo_contratos_plantillas',
	'angularjs/factorias/documentos/documentos',
	'angularjs/factorias/localizaciones',
	'angularjs/directivas/solo_numeros',
	'angularjs/directivas/html-bind-compile',
	'angularjs/filtros/filtros',
	'angularjs/angular-locale_es-cl',
	'select2.min',
	'bootstrap-datepicker'
));
?>
<script type="text/javascript">	
	$(document).ready(function() {
		$(".select2").select2({
			allowClear: true,
			width:'100%',
			minimumInputLength: -1,
		});

		$('.fecha').datepicker(
		{
			format: "dd/mm/yyyy",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true
		});
	});
</script>
