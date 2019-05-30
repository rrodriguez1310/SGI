app.service('reportsService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitions/reportII_json',
		});		
		return data;
	};

}]);