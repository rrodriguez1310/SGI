app.service('preguntasService', ['$http', function($http){
	this.induccionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'induccionPreguntas/index_json',
		});
		return data;
	};
}]);