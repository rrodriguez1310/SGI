<div ng-controller="ComprasReportes" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>
		<?php //echo $this->element('toolbox_angular'); ?>
		<div>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-resize-columns ui-grid-auto-resize class="grid"></div>
		</div>
	</div>

	<modal visible="showModal">

		<table class="table table-striped">
			<thead>
				<tr>
					<th>Nombre</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="usuario in usuarios">
					<td><i class="fa fa-check"></i> {{usuario.usuario}}</td>
				</tr>
			</tbody>
		</table>

		<button type="button" class="btn btn-default btn-block" ng-click="cerrarModal()" data-dismiss="modal">Cerrar</button>
	</modal>

</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/lista_roles_service',
		'angularjs/factorias/roles/roles',
		'angularjs/controladores/lista_roles',
		'angularjs/directivas/confirmacion',
		'angularjs/directivas/modal/modal',
	));
?>