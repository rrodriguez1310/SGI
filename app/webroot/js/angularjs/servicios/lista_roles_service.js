app.service('listaRoles', ["$http", function($http) {
	this.listaRoles = function(){
		var data = $http({
			method: 'GET',
			url: host25+'roles/lista_roles_json'
		});
		return data;
	};

	this.delete = function (id){
		return $http({
			method: "POST",
			url: host+"roles/delete",
			data: $.param({ id: id})
		});
	}

	this.usuarioRoles = function(id){
		var data = $http({
			method: 'GET',
			params: { getId:id },
			url: host25+'roles/usuariosPorRoles'
		});
		return data;	
	}
}]);