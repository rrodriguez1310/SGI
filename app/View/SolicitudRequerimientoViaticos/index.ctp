<div ng-controller="controllerSolicitudesViaticos" ng-init="carga('lista_viaticos')">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	
	<?php echo $this->element('botonera'); ?>

	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
	

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

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/solicitudes_rendicion_viaticos/solicitudesRendicionViaticos',
		'angularjs/controladores/solicitudes_rendicion_viaticos/solicitudesRendiconViaticoslistas',
		'angularjs/directivas/confirmacion'
	));
?>

