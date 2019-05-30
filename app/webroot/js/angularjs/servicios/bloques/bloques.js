app.service('bloquesService', function ($http){
	this.bloquesList = function(){
		return $http({
			method: "GET",
			url: host+"bloques/bloques_list"
		});
	}
});