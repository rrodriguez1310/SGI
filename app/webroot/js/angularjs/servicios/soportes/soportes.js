app.service('soportesService', function ($http){
	this.soportesList = function(){
		return $http({
			method: "GET",
			url: host+"soportes/soportes_list"
		});
	}
});