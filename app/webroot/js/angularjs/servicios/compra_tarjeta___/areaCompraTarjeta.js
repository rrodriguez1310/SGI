app.service('areaCompraTarjeta', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.viewAreajson = function(estado){
		var data = $http({
			params: {estado : estado},
			method: 'GET',
			url: host25+'/ComprasTarjetas/list_compras_area'
		});
		return data; 
	};

	this.deleteCompratarjeta = function(idCompra){
		var data = $http({
			params: {id : idCompra},
			method: 'GET',
			url: host25+'ComprasTarjetas/delete'
		});
		return data; 
	};

	/*this.estadoSolicitudCompra = function(idCompra, idEstado){
		var data = $http({
			params: {id : idCompra, idEstado:idEstado},
			method: 'GET',
			url: host25+'ComprasTarjetas/estado'
		});
		return data; 
	};


	this.estadoRespuesta = function(idCompra){
		var data = $http({
			method: 'GET',
			params: {id : idCompra},
			url: host25+'ComprasTarjetas/respuesta'
		});
		return data; 
	};*/
}]);