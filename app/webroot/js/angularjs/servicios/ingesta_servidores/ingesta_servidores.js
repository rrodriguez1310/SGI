app.service('ingestaServidoresService', function ($http){
	this.ingestaServidoresList = function(){
		return $http({
			method : "GET",
			url : host+"ingesta_servidores/ingesta_serviores_list"
		});
	}
});