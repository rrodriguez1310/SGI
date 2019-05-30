<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/compras/compras',
		'angularjs/controladores/compras/editar_codigo_sap',
	));
?>

<div ng-controller="BuscaCompras">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<?php //echo $this->element("loader"); ?>

	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>
		<div>
			<div>{{msg.lastCellEdited}}</div>
			<br>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-edit ui-grid-cellnav class="grid"></div>
		</div>
	</div>
</div>