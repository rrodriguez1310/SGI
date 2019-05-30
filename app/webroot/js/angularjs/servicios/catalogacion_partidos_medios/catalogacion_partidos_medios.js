app.service('catalogacionPartidosMediosService', function ($http){
	this.registrarCatalogacionPartidosMedios = function (formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_partidos_medios/registrar_medios",
			data: $.param(formulario)
		});
	};
	this.catalogacionPartidosMedio = function(idCatalogacionPartidosMedio){
		return $http({
			method: "GET",
			url: host+"catalogacion_partidos_medios/catalogacion_partidos_medio",
			params: {id:idCatalogacionPartidosMedio}
		});
	};
});