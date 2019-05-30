app.service('gerenciasService', ['$http', function($http){
	
	this.gerenciasList = function(){
		var data = $http({
			method: 'GET',
			url: host+'gerencias/gerencias_list',
		});		
		return data;
	};
}]);