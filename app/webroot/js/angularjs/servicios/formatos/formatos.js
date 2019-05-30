app.service('formatosService', function ($http){
	this.formatosList = function(){
		return $http({
			method: "GET",
			url: host+"formatos/formatos_list"
		});
	}
});