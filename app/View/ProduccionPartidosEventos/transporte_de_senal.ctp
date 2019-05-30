<style>input {margin-top: 0px;}</style>
<div ng-controller="ListaEventos" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h4>Transporte de Señal</h4> 
			</div>
		</div> 
		<?php echo $this->element('botonera'); ?>
		<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
	</div>
</div>

<?php 
	echo $this->Html->css("angular/text-angular/textAngular");
	
	echo $this->Html->script(array(
		'angularjs/controladores/app',			
		'angularjs/servicios/produccionPartidos/produccionPartidosEventos',		
		'angularjs/modulos/text-angular/textAngular.min',
		'angularjs/modulos/text-angular/textAngular-rangy.min',
		'angularjs/modulos/text-angular/textAngular-sanitize.min',		
		'angularjs/controladores/produccionPartidos/produccionPartidosEventos'
	));
?>