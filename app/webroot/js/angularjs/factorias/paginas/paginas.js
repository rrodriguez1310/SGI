app.factory('paginasFactory', function(){
	return {
		asocPaginasRoles : function (paginas, roles){
			if(roles.estado==1){
				data = [];
				rolesArray = [];
				angular.forEach(roles.data, function (rol){
					rolesArray[rol.Pagina.id] = {};
				});
				angular.forEach(roles.data, function (rol){
					rolesArray[rol.Pagina.id][rol.Role.id] = rol.Role.nombre;
				});
				angular.forEach(paginas, function (pagina){
					if(angular.isDefined(rolesArray[pagina.Id])){
						pagina.Roles = rolesArray[pagina.Id];	
					}else{
						pagina.Roles = [];
					}
					data.push(pagina);
				});
			}else{
				data = paginas;
			}
			return data;
		}
	};
});