app.service('almacenamientosService', function ($http){
	this.almacenamientosList = function(){
		return $http({
			method: "GET",
			url: host+"almacenamientos/almacenamientos_list"
		});
	}
});