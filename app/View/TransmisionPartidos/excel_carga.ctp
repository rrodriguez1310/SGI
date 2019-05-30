<style>input {margin-top: 0px;}</style>
<div ng-controller="TransmisionControllerCarga" ng-init="usuarioId(<?php echo $this->Session->Read("PerfilUsuario.idUsuario"); ?>)" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div class="row" ng-show="!loader">
		<div class="col-sm-12">
			<h4>Transmisión de Partidos Carga Excel</h4>
			<?php echo $this->element('botonera'); ?>
			<!--ul class="menu_secundario nav nav-pills">
				<li class="pull-right">
					<a href="" class="btn btn-default btn-mx" ng-click="mostrarUpload()"><i class="fa fa-file-excel-o"></i> Subir Excel</a>
				</li>
				<li class="pull-right">&nbsp;</li>
			</ul-->
			<div>
				<div ng-show="datosCargados" ui-grid="gridOptions" ui-grid-edit ui-grid-selection ui-grid-exporter class="grid"></div>
			</div>
			<div class="text-center">
				<button type="button" style="width:250px" ng-show="datosCargados" ng-click="consolidarInfo()" ng-disabled="!deshabilitado" class="btn btn-lg btn-primary">Consolidar Información</button>
			</div>			
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<modal visible="showModal">
				<form name="subirCsvForm" id="subirCsvForm" novalidate>
					<div class="form-group text-left">
						<label for="archivo" class="col-xs-9 control-label">Adjuntar archivo: (Max. 2MB)</label> 
						<div class="col-xs-3" style="display:inline">
						    <button class="btn btn-success btn-md" accept=".csv" ngf-select name="archivo" ngf-change="settingFile(archivo)" id="archivo" ng-model="archivo">Examinar...</button>&nbsp;
						    <label class="baja" ng-if="setFile" style="font-weight: normal !important;">
						    	{{nombreArchivo}} {{sizeArchivo}}&nbsp;&nbsp;
						    	<a hre="#" class="btn btn-xs" ng-click="eliminarArchivo(archivo)">
						    		<i class="fa fa-times"></i>
						    	</a>
						    </label>
						</div>						
					</div>
				</form>
				<div class="modal-footer">
			        <button type="button" class="btn btn-default" ng-click="cerrarModal()" data-dismiss="modal">Cerrar ventana</button>
			    </div>
			</modal>
		</div>
	</div>

</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/transmisionPartidos/transmisionPartidos',
		'angularjs/controladores/transmisionPartidos/transmisionPartidos',
		'angularjs/directivas/confirmacion',
		'angularjs/directivas/modal/modal'
	));
?>
