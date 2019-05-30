<div ng-controller="sistemasBitacorasIndex" class="col-md-12" ng-cloak ng-init="usuarioId(<?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="ShowContenido">
		<div class="row">
			<div class="col-md-12 text-center">
				<h3>Listado Bitacora</h3>
			</div>
		</div>
		<br />
		<div class="row">
			<div class="col-md-12">
				<?php echo $this->element('botonera'); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid" ui-grid-resize-columns ui-grid-auto-resize></div>
			</div>
		</div>
	</div>
</div>
<?php
echo $this->Html->script(array(
	"angularjs/controladores/app",
	"angularjs/servicios/sistemas_bitacoras/sistemas_bitacoras",
	"angularjs/servicios/areas/areas",
	//"angularjs/servicios/gerencias/gerencias",
	"angularjs/servicios/users/lista_users_service",
	"angularjs/servicios/sistemas_responsables/sistemas_responsables",
	"angularjs/servicios/trabajadores",
 	"angularjs/factorias/users/users",
 	"angularjs/factorias/factoria",
	"angularjs/controladores/sistemas_bitacoras/sistemas_bitacoras",
));
?>
