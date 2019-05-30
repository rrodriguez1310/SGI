app.service('compraTarjeta', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.listaCompraTarjeta = function(estado){
		var data = $http({
			params: {estado : estado},
			method: 'GET',
			url: host25+'/ComprasTarjetas/list_compras_tarjeta'
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

	this.estadoSolicitudCompra = function(idCompra, idEstado, idEstadoCompra, obs){

		var data = $http({
			params: {id : idCompra, idEstado : idEstado, idEstadoCompra:idEstadoCompra, observacion : obs},
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
	};
}]);