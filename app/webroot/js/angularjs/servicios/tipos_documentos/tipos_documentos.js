app.service('tiposDocumentosService', function($http) {

	this.tiposDocumentosList = function(){
		var data = $http({
			method: "GET",
			url: host+'tipos_documentos/tipos_documentos_list',
		});
		return data;
	};
});