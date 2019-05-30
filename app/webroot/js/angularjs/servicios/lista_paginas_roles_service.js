app.service('listaPaginasRoles', ["$http", function($http) {
	this.listaPaginasRoles = function(id){
		var data = $http({
			method: 'GET',
			params: {id},
			url: host25+'PaginasRoles/paginas_roles_json'
		});
		return data;
	};
}]);