app.service('leccionesService', ['$http', function($http){
	this.induccionList = function(){
		var data = $http({
			method: 'GET',
			url: host+'induccionEtapas/index_json',
		});
		return data;
	};
}]);