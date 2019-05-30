app.service('servicioMontosFijos', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/"
	this.listaMontosFondoFijos = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'MontosFondoFijos/list_montos_fijos'
		});
		return data; 
	};

	this.listaMontosFondoFijosLista = function(){ 
		var data = $http({
			//params: {id : idCompra},
			method: 'GET',
			url: host25+'MontosFondoFijos/lista_montos'
		});
		return data; 
	};

	this.addMontos = function(datosMonto){ 
		var data = $http({
			params: {datos : datosMonto},
			method: 'GET',
			url: host25+'MontosFondoFijos/add_montos'
		});
		return data; 
	};
	
}]);