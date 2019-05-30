app.service('localizacionesService', ["$http", function($http) {

	this.localizacionesList = function(){
		var data = $http({
			method: "GET",
			url: host+'localizaciones/localizaciones_list',
		});
		return data;
	};

}]);