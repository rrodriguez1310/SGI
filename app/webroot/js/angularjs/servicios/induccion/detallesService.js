app.service('detallesService', ['$http', function($http){
	this.induccionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'induccionDetalles/index_json',
		});
		return data;
	};
}]);