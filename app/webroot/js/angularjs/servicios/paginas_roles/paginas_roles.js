app.service('paginasRoles', ["$http", function($http) {
	
	this.add = function(paginaId, rolId){
		var data = $http({
			method: 'GET',
			params: { idPagina:paginaId , idRol:rolId },
			url: host25+'PaginasRoles/add'
		});
		return data;
	};
	
	this.paginasAsociadasRoles = function(rolId){
		var data = $http({
			method: 'GET',
			params: { idRol:rolId },
			url: host25+'PaginasRoles/paginas_asociadas_roles'
		});
		return data;
	};

	this.paginasRolesList = function(){
		var data = $http({
			method: 'GET',
			url: host25+'paginas_roles/paginas_roles_list'
		});
		return data;
	};

	this.deleteAsoc = function(paginaId, rolId){
		var data = $http({
			method: 'POST',
			data: $.param({ idPagina:paginaId , idRol:rolId }),
			url: host+'PaginasRoles/delete'
		});
		return data;
	};
}]);