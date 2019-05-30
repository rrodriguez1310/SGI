app.service('listaCorreosTiposService', ["$http", function($http) {

	this.listaCorreosTipos = function(){
		var data = $http({
			method: 'GET',
			url: host+'lista_correos_tipos/lista_correos_tipos',
		});		
		return data;
	};

}]);