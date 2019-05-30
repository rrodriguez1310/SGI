app.service('nivelEducacionsService', ['$http', function ($http){
	
	this.nivelEducacionsList = function(){
		var data = $http({
			method: 'GET',
			url: host+'nivel_educacions/nivel_educacions_list',
		});		
		return data;
	};
}])