app.service('sistemaPrevisionesService', ['$http', function($http){
	
	this.sistemaPrevisionesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'sistema_previsiones/sistema_previsiones_list',
		});		
		return data;
	};
}]);