app.service('collaboratorProductsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'RecognitionCollaborators/products_json',
		});		
		return data;
	};

}]);