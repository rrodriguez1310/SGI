app.service('monthsService', ["$http", function ($http) {
	this.monthsList = function(){
		return $http({
			method : "GET",
			url : host+"months/months_list"
		});
	}
}]);