app.service('collaboratorService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionBossDepartaments/collaborator_json',
		});		
		return data;
	};

}]);