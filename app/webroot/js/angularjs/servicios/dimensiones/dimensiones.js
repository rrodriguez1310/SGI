app.service('dimensionesService', ["$http", function($http) {

	this.dimensionesListado = function(){
		var data = $http({
			method: 'GET',
			url: host+'dimensiones/json_listar_dimensiones',
		});		
		return data;
	};
}]);