<div ng-controller="controllerRequerimientosRendicion" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	
	<?php echo $this->element('botonera'); ?>

	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid">
	</div>
	

<!--modal visible="showModal">
	<div class="row"> 
		<div class="col-md-12">
		 <h4>¿Desea eliminar registro?</h4>
		</div>
	</div>
    <div class="row">
		<div class="col-xs-offset-8 col-md-12">
			<button type="button" class="btn btn-primary"  ng-click="delete(id)" >Eliminar</button>
			<button type="button" class="btn btn-warning" ng-click="closeModal()">Cerrar</button>
		</div>
	</div>
</modal-->
</div>

<!--'angularjs/directivas/upload_file/upload_documento',-->
<?php 
	echo $this->Html->script(array(
		'bootstrap-datepicker',
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_requerimiento_servicio/solicitudesRequerimiento',
		'angularjs/controladores/solicitudes_requerimientos_fondos/solicitudes_requerimientos_rendicion',
		'angularjs/directivas/confirmacion'
	));
?>

