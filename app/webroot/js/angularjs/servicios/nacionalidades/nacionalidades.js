app.service('nacionalidadesService', ['$http', function ($http){
	this.nacionalidadesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'nacionalidades/nacionalidades_list',
		});		
		return data;
	};

}]);