app.service('cargosFamiliasService', function ($http){
	
	this.cargosFamiliasList = function(){
		var data = $http({
			method: 'GET',
			url: host+'cargos_familias/cargos_familias_list',
		});		
		return data;
	};
});