<div ng-controller="catalogacionRequerimientosIndex" ng-cloak ng-init="usuarioId(<?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Listado Requerimiento</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns external-scopes="scopeExternoGrilla"></div>
			</div>
		</div>
	</div>
	<modal visible="showModal">
		<form class="form-horizontal" name="catalogacionRAsignarResponsableForm" novalidate>
			<div class="form-group" ng-class="{ 'has-error': !catalogacionRAsignarResponsableForm.responsable.$valid }">
				<label for="responsable" class="col-md-3 control-label">Responsable</label>
				<div class="col-md-9">
					<select2 class="form-control" ng-model="formulario.CatalogacionRequerimiento.catalogacion_r_responsable_id" id="responsable" name="responsable" placeholder="Seleccione un responsable" s2-options="valor.id as (tiposResponsables[valor.tipo]+' - '+usuariosPorId[valor.user_id].UsuarioNombre) for valor in catalogacionRResponsablesList" required ng-change="cambioResponsable()">
						<option value=""></option>
					</select2>
				</div>
			</div>
		</form>
		<div class="modal-footer">
			<div class="row">
				<div class="col-md-12 text-center">
					<button type="button" class="btn btn-primary" ng-click="catalogacionResponsable()" ng-disabled="!catalogacionRAsignarResponsableForm.$valid"><i class="fa fa-pencil"></i> Asignar</button>
	        		<button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal"><i class="fa fa-reply-all"></i> Cerrar</button>		
				</div>
			</div>
	    </div>
	</modal>
</div>

<?php
 	echo $this->Html->script(array(
 		"angularjs/controladores/app",
 		'angularjs/directivas/modal/modal',
 		'angularjs/directivas/confirmacion',
 		"angularjs/servicios/catalogacion_requerimientos/catalogacion_requerimientos",
 		"angularjs/servicios/catalogacion_r_responsables/catalogacion_r_responsables",
 		"angularjs/servicios/users/lista_users_service",
 		"angularjs/factorias/users/users",
 		"angularjs/factorias/copias/copias",
 		"angularjs/factorias/formatos/formatos",
 		"angularjs/factorias/soportes/soportes",
 		"angularjs/factorias/catalogacion_r_tipos/catalogacion_r_tipos",
 		"angularjs/factorias/catalogacion_r_responsables/catalogacion_r_responsables",
 		"angularjs/controladores/catalogacion_requerimientos/catalogacion_requerimientos",
 		"select2.min"
 	)); 
?>