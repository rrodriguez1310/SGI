app.service('comunasService', ['$http', function ($http){
	
	this.comunasList = function(){
		var data = $http({
			method: 'GET',
			url: host+'comunas/comunas_list',
		});		
		return data;
	};
}]);