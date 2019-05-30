app.service('recognitionCollaborator', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionCollaborators/index_Json',
		});		
		return data;
	};

}]);