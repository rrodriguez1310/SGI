app.service('listaPaginas', ["$http", function($http) {
	this.listaPaginas = function(){
		var data = $http({
			method: 'GET',
			url: host25+'paginas/lista_paginas_json'
		});
		return data;
	};
}]);