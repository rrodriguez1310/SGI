app.service('catalogacionPartidosService', ["$http", function($http) {
	this.catalogacionPartidos = function(){
		return $http({
			method: 'GET',
			url: host+'catalogacion_partidos/catalogacion_partidos'
		});
	};

	this.catalogacionPartido = function (catalogacionPartidoId){
		return $http({
			method: "GET",
			params : {id : catalogacionPartidoId},
			url : host+'catalogacion_partidos/catalogacion_partido'
		});
	};

	this.registrarCatalogacionPartido = function (formulario){
		return $http({
			method: "POST",
			url: host+"catalogacion_partidos/registrar_catalogacion_partidos",
			data: $.param(formulario)
		});
	};
}]);