app.service('bossDepartamentsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionBossDepartaments/bossDepartaments',
		});		
		return data;
	};

	this.bossDepartamentsPost = function(id){
		var data = $http({
			method: 'POST',
			param:{id:id},
			url: host+'recognitionBossDepartamentss/add',
		});		
		return data;
	};

}]);
