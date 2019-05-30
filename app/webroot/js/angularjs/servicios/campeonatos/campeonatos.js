app.service('campeonatosService', function ($http){
	this.campeonatosList = function()
	{
		return $http({
			method : "GET",
			url : host+"campeonatos/campeonatos_list"
		});
	}
	
});