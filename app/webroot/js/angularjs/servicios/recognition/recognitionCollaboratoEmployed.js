app.service('recognitionCollaboratorService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionCollaborators/collaborator_json',
		});		
		return data;
	};

}]);