app.service('progresoService', function($http){

	this.enviarCorreoPartidos = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'InduccionPantallas/avance',
			data: $.param(parametros)
		});
		return data;
	};

})