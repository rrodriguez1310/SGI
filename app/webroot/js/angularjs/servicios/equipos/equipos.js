app.service('equiposService', function ($http){
	this.equiposList = function ()
	{
		return $http({
			method : "GET",
			url : host + "equipos/equipos_list"
		});
	};
});