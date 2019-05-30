<div ng-controller="contenidosController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="text-center"><h2>Seleccione un contenido</h2></div>
	<?php echo $this->element('botonera'); ?>


	<div>
		<br>
		<div ng-show="tablaDetalle">
			<!--div ui-grid="gridOptions" ui-grid-pinning ui-grid-expandable ui-grid-grouping ui-grid-selection ui-grid-exporter class="grid"></div-->
			<div ui-grid="gridOptions"  ui-grid-grouping ui-grid-selection ui-grid-exporter class="grid"></div>
		</div>
	</div>

</div>
	
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/induccion/contenidosService',
		'angularjs/controladores/induccion/contenidosController',
		'angularjs/directivas/confirmacion',
	));

	//librerias
	/*
	echo $this->Html->script(array("http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular.js"));
    echo $this->Html->script(array("http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-touch.js"));
    echo $this->Html->script(array("http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-animate.js"));
    echo $this->Html->script(array("http://ajax.googleapis.com/ajax/libs/angularjs/1.5.0/angular-aria.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/csv.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/pdfmake.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/vfs_fonts.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/lodash.min.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/jszip.min.js"));
    echo $this->Html->script(array("http://ui-grid.info/docs/grunt-scripts/excel-builder.dist.js"));
    echo $this->Html->script(array("http://ui-grid.info/release/ui-grid.js"));
	echo $this->Html->css(array("http://ui-grid.info/release/ui-grid.css"))
	*/
?>