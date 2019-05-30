app.service('motivoRetirosService', ['$http', function($http){
	
	this.motivoRetirosList = function(){
		var data = $http({
			method: 'GET',
			url: host+'motivo_retiros/motivo_retiros_list',
		});		
		return data;
	};
}]);