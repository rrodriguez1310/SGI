<style>input {margin-top: 0px;}</style>
<div ng-controller="ProduccionNombres" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-sm-12">
				<h4>Nombre trabajadores módulo producción partidos</h4>
			</div>
		</div>
		<?php echo $this->element('botonera'); ?>
		<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/produccionContactos/produccionContactos',
		'angularjs/servicios/produccionContactos/produccionContactos',
		'angularjs/directivas/confirmacion'
	));
?>
<script>
	$('.tool').tooltip();
</script>