<id class="mensaje"></id>
<div ng-controller="listaCorreosAdd" ng-cloak>
	<div class="col-md-12">
		<form name="formularioAdd" novalidate>
			<div class="form-group">
				<h4 class="text-center">Registrar mensaje</h4>
			</div>
			<br />
			<div class="form-group" ng-class="{ 'has-error': !formularioAdd.nombre.$valid }">
				<label class="control-label" for="nombre">
					Nombre
				</label>	
				<input class="form-control" id="nombre" name="nombre" type="text" placeholder="Ingrese nombre" ng-model="formulario.ListaCorreo.nombre" required>
			</div>
			<div class="form-group" ng-class="{ 'has-error': !formularioAdd.descripcion.$valid }">
				<label class="control-label" for="descripcion">
					Descripción
				</label>
				<input class="form-control" id="descripcion" name="descripcion" type="text" placeholder="Ingrese descripción opcional si es necesario" ng-model="formulario.ListaCorreo.descripcion">
			</div>
			<div class="form-group" ng-class="{ 'has-error': !formularioAdd.descripcion.$valid }">
				<label class="control-label" for="descripcion">
					Titulo
				</label>
				<input class="form-control" id="titulo" name="titulo" type="text" placeholder="Ingrese titulo opcional si es necesario" ng-model="formulario.ListaCorreo.titulo">
			</div>
			<div class="form-group" ng-class="{ 'has-error': !formularioAdd.tipo.$valid }">
				<label class="control-label" for="mensaje">
					Tipo
				</label>
				<select class="select2" ng-model="formulario.ListaCorreo.lista_correos_tipo_id" id="tipo" name="tipo" placeholder="Selecciones un tipo" ng-options="tipo.id as tipo.nombre for (k, tipo) in tipos track by tipo.id" required>
					<option value=""></option>
				</select>
			</div>
			<div class="form-group" ng-class="{ 'has-error': !formularioAdd.mensaje.$valid }">
				<label class="control-label">
					Mensaje
				</label>
				<div name="mensaje" text-angular ng-model="formulario.ListaCorreo.mensaje" required></div>	
			</div>
			<div class="ng-show">
				<input type="hidden" ng-model="formulario.ListaCorreo.estado" ng-init="formulario.ListaCorreo.estado=1">
			</div>
			<div class="form-group">
				<div class="col-md-12 text-center">
					<button class="btn btn-primary btn-lg" ng-click="registrarListaCorreos()" ng-disabled="!formularioAdd.$valid"><i class="fa fa-pencil"></i> Registrar</button>
					<a class="volver btn btn-default btn-lg" href="{{ locationListaCorreos }}">
						<i class="fa fa-mail-reply-all"></i>
						Volver
					</a>
				</div>
			</div>
		</form>
	</div>
</div>
<?php
echo $this->Html->css("angular/text-angular/textAngular");

echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/servicios/lista_correos',
	'angularjs/servicios/lista_correos_tipos',
	'angularjs/factorias/lista_correos_tipos',
	'angularjs/controladores/lista_correos',
	'angularjs/angular-locale_es-cl',
	'angularjs/modulos/text-angular/textAngular-rangy.min',
	'angularjs/modulos/text-angular/textAngular-sanitize.min',
	'angularjs/modulos/text-angular/textAngular.min',
	'select2.min'
	)
);
?>

<script type="text/javascript">	
	$(document).ready(function() {
		$(".select2").select2({
			allowClear: true,
			width:'100%',
			minimumInputLength: -1,
		});
	});
</script>