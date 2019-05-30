app.service('tipoContratosService', ["$http", function($http) {

	this.tipoContratosList = function(){
		var data = $http({
			method: "GET",
			url: host+'tipo_contratos/tipo_contratos_list',
		});
		return data;
	};

}]);