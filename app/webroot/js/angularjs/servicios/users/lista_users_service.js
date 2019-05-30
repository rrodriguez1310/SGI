app.service('listaUsers', ["$http", function($http) {
	this.listaUsers = function(){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			url: host25+'users/lista_usuarios_json'
		});
		return data;
	};

	this.rolesUsuario = function(idUsuario){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {usuarioId :idUsuario},
			url: host25+'users/roles_usuario'
		});
		return data;
	}; 
	
	this.addUserRol = function(idUsuario, idRoles){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {usuarioId :idUsuario, rolesId: idRoles},
			url: host25+'users/add_roles_usuarios'
		});
		return data;
	};

	this.botonesPorPagina = function(idPagina){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {paginaId :idPagina},
			url: host25+'paginas/lista_botones_json'
		});
		return data;
	};

	this.addBotonesPaginas = function(idBotones, idPagina, idRol){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {botonesId :idBotones, paginaId : idPagina, rolId: idRol},
			url: host25+'paginas_botones/add'
		});
		return data;
	};

	this.deleteBotonesPaginas = function(idBotones, idPagina, idRol){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {botonesId :idBotones, paginaId : idPagina, rolId: idRol},
			url: host25+'paginas_botones/delete'
		});
		return data;
	};

	this.botonesRol = function(idPagina, idRol){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {paginaId: idPagina, rolId: idRol},
			url: host25+'paginas_botones/botones_roles'
		});
		return data;
	};

	this.delete = function(id){
		usuario = {
			User : {
				id : id,
				estado : 0
			}
		}
		return $http({
			method : "POST",
			url : host+"users/delete",
			data : $.param(usuario)
		});
	}
}]);
