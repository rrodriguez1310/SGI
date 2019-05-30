app.service('pruebas', ['$http', function($http){
	
	this.listaPruebas = function(){
		var data = $http({
			method: 'GET',
			url: host+'pruebas/pruebas_list',
		});		
		return data;
	};
}]);