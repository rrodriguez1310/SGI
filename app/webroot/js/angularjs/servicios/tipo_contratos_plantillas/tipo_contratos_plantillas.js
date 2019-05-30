app.service('tipoContratosPlantillasService', function ($http){
	this.tipoContratosPlantillas = function(){
		return $http({
			method : "GET",
			url : host+"tipo_contratos_plantillas/tipo_contratos_plantillas"
		});
	};
	this.tipoDocumentosContrato = function(idTipoContrato){
		return $http({
			method : "GET",
			url : host+"tipo_contratos_plantillas/tipo_contratos_plantillas/"+idTipoContrato
		});
	}
});