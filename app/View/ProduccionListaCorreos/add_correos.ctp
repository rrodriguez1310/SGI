<div ng-controller="ListaAddCorreo" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
		<div ng-show="tablaDetalle">
			<div class="row">
				<div class="col-md-12 text-center">
					<h3>Lista Correos : <strong><?php echo __($listaSeleccionada); ?></strong></h3>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-md-12">
					<?php echo $this->element('botonera'); ?>					
					<div class="col-xs-12">
						<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ui-grid-move-columns ui-grid-pinning class="grid"></div>
					</div>
				</div>
			</div>
		</div>		
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/produccionListaCorreos/produccionListaCorreos',
		'angularjs/controladores/produccionListaCorreos/produccionListaCorreos',
		'angularjs/directivas/botones_extras/boton_add_contacto_lista'
	));
?>
<script>
	$('.tool').tooltip();
</script>