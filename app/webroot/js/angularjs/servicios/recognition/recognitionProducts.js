app.service('productsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionProducts/index_json',
		});		
		return data;
	};
}]);