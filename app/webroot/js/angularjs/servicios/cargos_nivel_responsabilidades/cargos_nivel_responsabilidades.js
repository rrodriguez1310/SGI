app.service('cargosNivelResponsabilidadesService', function ($http){

	this.cargosNivelResponsabilidadesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'cargos_nivel_responsabilidades/cargos_nivel_responsabilidades_list',
		});		
		return data;
	};
});