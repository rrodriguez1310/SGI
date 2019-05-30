<style>input {margin-top: 0px;}</style>
<div ng-controller="TransmisionController" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>	
	<div class="row" ng-show="!loader">
		<div class="col-sm-12">
			<h4>Transmisión de Partidos</h4>
			<div class="row">
				<div class="col-md-12">
					<ul class="menu_secundario nav nav-pills">
						<li class="pull-right">
							<a href="" class="btn btn-default btn-mx" ng-click="generaReporte()"><i class="fa fa-file-pdf-o"></i> Generar Reporte</a>
						</li>
						<li class="pull-right">
							<a href="" class="btn btn-default btn-mx" ng-click="generaExcel()"><i class="fa fa-file-excel-o"></i> Generar Excel Para Cargar Datos</a>
						</li>
					</ul>
				</div>
			</div>
			<?php echo $this->element('botonera'); ?>
			<div>
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
			</div>
		</div>
	</div>	
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/transmisionPartidos/transmisionPartidos',
		'angularjs/controladores/transmisionPartidos/transmisionPartidos',
		'angularjs/directivas/confirmacion'
	));
?>
