app.service('recognitionService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionCategories/index_json',
		});		
		return data;
	};

	
}]);