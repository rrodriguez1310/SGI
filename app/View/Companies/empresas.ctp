<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/lista_empresas',
	));
?>
<div ng-controller="ListaEmpresas">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('buscador_tablas'); ?>
		<div>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-resize-columns class="grid" ></div>
		</div>
	</div>
</div>

<script>
	$('.tool').tooltip();
</script>