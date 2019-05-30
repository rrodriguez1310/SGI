app.service('listaCorreosService', ["$http", function($http) {

	this.listaCorreos = function(){
		var data = $http({
			method: 'GET',
			url: host+'lista_correos/lista_correos',
		});		
		return data;
	};
	this.listaCorreo = function(id){
		var data = $http({
			method: 'GET',
			url: host+'lista_correos/lista_correo',
			params: { "id" : id }
		});		
		return data;
	};

	this.registrarListaCorreos = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'lista_correos/registrar_lista_correos',
			data: $.param(formulario)
		});
		
		return data;
	};

	this.editarListaCorreos = function(formulario){
		console.log(formulario);
		var data = $http({
			method: 'POST',
			url: host+'lista_correos/editar_lista_correos',
			data: $.param(formulario)
		});
		
		return data;
	};

	this.eliminar = function(parametros){
		var data = $http({
			method: 'POST',
			url: host+'lista_correos/delete',
			data: $.param(parametros)
		});
		return data;
	};

	this.registrarTrabajadoresListaCorreos = function(parametros){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores_lista_correos/registrar_trabajadores_lista_correos',
			data: $.param(parametros)
		});
		return data;
	};

	this.listaCorreosTrabajadores = function(id){
		var data = $http({
			method: 'GET',
			url: host+'lista_correos/lista_correos_trabajadores',
			params: { "id" : id }
		});		
		return data;
	};

	this.eliminarCorreoAsociado = function(trabajador, listaCorreo){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores_lista_correos/eliminar_correo_asociado',
			data: $.param({ trabajador: trabajador, listaCorreo: listaCorreo})
		});
		return data;
	};

}]);