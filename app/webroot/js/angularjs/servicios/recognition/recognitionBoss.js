app.service('bossService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitionBossDepartaments/indexBossJson',
		});		
		return data;
	};

}]);