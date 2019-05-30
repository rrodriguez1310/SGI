app.service('abonados', ["$http",'$location',  function($http, $location) {
	//parametros = location.search.substring(1); 
	//parametros = parametros.split("/");

	this.listaAbonados = function(fecha){
		var data = $http({
			params: {getFecha : fecha},
			method: 'GET',
			url: host25+'subscribers/lista_graficos'
		});
		return data; 
	};
}]);