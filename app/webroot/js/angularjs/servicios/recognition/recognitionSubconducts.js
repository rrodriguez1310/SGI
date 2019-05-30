app.service('subconductsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionSubconducts/index_json',
		});		
		return data;
	};
}]);
