app.service('conductsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionConducts/index_json',
		});		
		return data;
	};
}]);
