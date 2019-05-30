app.service('catalogacionRResponsablesService', function ($http){
	this.catalogacionRResponsableXUsuario = function (idUsuario){
		return $http({
			method: "POST",
			url: host+"catalogacion_r_responsables/responsable_usuario",
			params : { id : idUsuario }
		});
	}

	this.catalogacionRResponsablesList = function(){
		return $http({
			method: "GET",
			url: host+"catalogacion_r_responsables/catalogacion_r_responsables_list",
		});
	}	
})