<div ng-controller="controllerCompras">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	
	<?php echo $this->element('botonera'); ?>

	<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid" id="grilla"></div>
	<a href="<?php echo $this->Html->url(array("controller"=>"compras_tarjetas", "action"=>"view"))?>/{{id}}/NULL">Detalle</a>
	
<modal visible="showModal">
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
</modal>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compra_tarjeta/compraTarjeta',
		'angularjs/directivas/modal/modal',
		'angularjs/controladores/compra_tarjeta/compra_tarjeta',
		
	));
?>