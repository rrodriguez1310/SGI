app.service('localizacionesService', ["$http", function($http) {

	this.localizaciones = function(){
		var data = $http({
			method: "GET",
			url: host+'localizaciones/localizaciones',
		});
		return data;
	};

}]);