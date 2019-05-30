app.directive('ngToolboxTrabajadores',['$location', function($location) {
	var absUrl = $location.absUrl();
	var getHtml = '\
		<div class="panel panel-default">\
			<div class="panel-heading">\
				<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>\
			</div>\
			<div class="panel-body">\
				<ul class="list-inline menu_superior_angular">\
					<li class="addbtn">\
						<a href="'+absUrl+'/add"  class="btn-sm btn btn-primary tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Insertar"><i class="fa fa-floppy-o"></i></a>\
					</li>\
					<li ng-show="boton">\
						<a href="'+absUrl+'/edit/{{id}}" ng-show="btnedit" class="btn-sm btn btn-success tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Editar"><i class="fa fa-pencil"></i></a>\
					</li>\
					<li ng-show="boton">\
						<a  href="'+absUrl+'/view/{{id}}" ng-show="btnview" class="btn-sm btn btn-info tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Ver"><i class="fa fa-eye"></i></a>\
					</li>\
					<li ng-show="boton">\
						<a href="'+absUrl+'/imprimir_contrato/{{id}}" ng-show="btnimprimir_contrato" class="btn-sm btn btn-default tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Imprimir Contrato" ><i class="fa fa-print"></i></a>\
					</li>\
					<li ng-asignaroles></li>\
					<li ng-botonasignaroles></li>\
				</ul>\
				<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />\
			</div>\
		</div>\
	';
  return {
    restrict: 'A',
    template: getHtml
  }
}]);

app.directive('trabajadoresListaDocumentosDirective',['$location', function($location) {
	var absUrl = $location.absUrl();
	var getHtml = '\
		<div class="panel panel-default">\
			<div class="panel-heading">\
				<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>\
			</div>\
			<div class="panel-body">\
				<ul class="list-inline menu_superior_angular">\
					<li ng-show="btnDownload" style="padding-left:5px">\
						<a download class="btn-sm btn btn-primary tool" ng-href="'+host+'/files/trabajadores/{{ rutaArchivo }}" data-toggle="tooltip" data-placement="top" title="Descargar"><i class="fa fa-download"></i></a>\
					</li>\
					<li ng-show="btnSubirArchivo">\
						<a ngf-select ng-model="documentoGrid" ngf-change="subirDocumentoGrid({{ subirArchivoGrid }})" name="archivo" class="btn-sm btn btn-default tool" ng-click="" data-placement="bottom" data-toggle="tooltip" data-original-title="Subir Archivo"><i class="fa fa-upload"></i></a>\
					</li>\
					<li ng-show="boton">\
						<a href="" ng-click="documentoDelete(subirArchivoGrid)" class="btn-sm btn btn-danger tool" data-placement="bottom" data-toggle="tooltip" data-original-title="Eliminar documento" ><i class="fa fa-trash-o"></i></a>\
					</li>\
					<li ng-asignaroles></li>\
					<li ng-botonasignaroles></li>\
				</ul>\
				<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />\
			</div>\
		</div>\
	';
  return {
    restrict: 'A',
    template: getHtml
  }
}]);

app.directive('trabajadoresPendientesDirective', function() {
	var getHtml = '\
		<div class="panel panel-default">\
			<div class="panel-heading">\
				<h3 class="panel-title"><i class="fa fa-cogs"></i> Acciones</h3>\
			</div>\
			<div class="panel-body">\
				<ul class="list-inline menu_superior_angular">\
					<li ng-show="boton" style="padding-left:5px">\
						<a class="btn-sm btn btn-success tool" ng-href="'+host+'trabajadores/edit/{{id}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil"></i></a>\
					</li>\
				</ul>\
				<input type="text" class="form-control input-sm" ng-model="search" ng-change="refreshData(search)" placeholder="Buscar" />\
			</div>\
		</div>\
	';
  return {
    restrict: 'A',
    template: getHtml
  }
});