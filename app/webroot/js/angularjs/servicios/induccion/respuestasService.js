app.service('respuestasService', ['$http', function($http){
	this.induccionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'induccionRespuestas/index_json',
		});
		return data;
	};
}]);