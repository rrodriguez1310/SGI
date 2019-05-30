app.service('horariosService', ["$http", function($http) {

	this.horariosList = function(){
		var data = $http({
			method: "GET",
			url: host+'horarios/horarios_list',
		});
		return data;
	};

}]);