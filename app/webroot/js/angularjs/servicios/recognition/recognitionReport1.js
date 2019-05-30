app.service('recognitionReportService', ['$http', function($http){
	
	this.recognitionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'recognitions/report1_json',
		});		
		return data;
	};

}]);