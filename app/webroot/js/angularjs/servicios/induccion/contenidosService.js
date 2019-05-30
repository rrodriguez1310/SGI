app.service('contenidosService', ['$http', function($http){
	this.induccionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'induccionContenidos/index_json',
		});
		return data;
	};
}]);