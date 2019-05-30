app.service('areasService', ['$http', function($http){
	
	this.areasList = function(){
		var data = $http({
			method: 'GET',
			url: host+'areas/areas_list',
		});		
		return data;
	};
}]);