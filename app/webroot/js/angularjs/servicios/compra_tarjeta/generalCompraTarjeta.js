app.service('generalCompraTarjeta', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.viewGeneralJson = function(estado){
		var data = $http({
			params: {estado : estado},
			method: 'GET',
			url: host25+'/ComprasTarjetas/view_compras_tarjeta_general'
		});
		return data; 
	};

	this.insertRecurrencia = function(folio, monto, idCompra){
		var data = $http({
			params: { folio:folio, monto:monto, idCompra:idCompra},
			method: 'GET',
			url: host25+'ComprasTarjetas/insertRecurrencia'
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