<id class="mensaje"></id>
<div ng-controller="listaCorreosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element("toolbox_angular"); ?>
		<div>
			<br>	
			<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>
</div>
<?php 
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/servicios/lista_correos',
	'angularjs/factorias/lista_correos',
	'angularjs/controladores/lista_correos',
	'angularjs/directivas/confirmacion.js',
	'angularjs/angular-locale_es-cl',
	)
);
?>