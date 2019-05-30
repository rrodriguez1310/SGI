<div ng-controller="ListaUsers" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera', array('botones'=>(isset($botones) ? $botones : ""))); ?>
		<?php //echo $this->element('toolbox_angular'); ?>
		<div class="col-xs-6">	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
		<div class="col-xs-6">
			<div ng-rolesactivos></div>
		</div>
	</div>
	<modal title="Modal" visible="showModal">
		<ul class="list-unstyled">
			<li ng-repeat="nombreBoton in botones">
				<input type="checkbox" name="selectedBotones[]" value="{{nombreBoton.PaginaId}}" ng-checked="seleccionaBotones.indexOf(nombreBoton.PaginaId) > -1" ng-click="botonesSeleccionados(nombreBoton.PaginaId)">{{nombreBoton.AccionFantasia}}
			</li>
		</ul>
		<!--p>{{seleccionaBotones}}</p-->
		<div class="modal-footer">
	        <button type="button" class="btn btn-primary" ng-click="guardarPaginasBotones(seleccionaBotones)">Asociar</button>
	        <button type="button" class="btn btn-danger" ng-click="eliminaPaginasBotones(seleccionaBotones)">Desasociar</button>
	        <button type="button" class="btn btn-default cerrar" data-dismiss="modal">Cerrar</button>
		</div>
	</modal>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/directivas/confirmacion',
		'angularjs/servicios/users/lista_users_service',
		'angularjs/servicios/roles/lista_nombres_roles',
		'angularjs/servicios/paginas_roles/paginas_roles',
		'angularjs/servicios/lista_roles_service',
		'angularjs/controladores/users/lista_usuarios',
		'angularjs/directivas/users/lista_roles_nombres',
		'angularjs/directivas/modal/modal',
	));
?>
<script>
	$('.tool').tooltip();
</script>