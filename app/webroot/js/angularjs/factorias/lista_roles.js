app.factory('listaRolesFactory', ["$q", "listaRolesService", function($q, listaRolesService) {
	return {
		listaRoles : function() {			
			return $q(function(resolve, reject) {
				rolesGet = listaRolesService.listaRoles();
				rolesGet.success(function(data, status, headers, config){

					/*
					 if(data["estado"]!=0){
		             	respuesta = [];
		             	angular.forEach(data["data"], function(valor, key){
		                    respuesta.push({
		                    	"id": valor["ListaCorreosMensaje"]["id"],
		                    	"nombre": valor["ListaCorreosMensaje"]["nombre"],
		                    	"descripcion": valor["ListaCorreosMensaje"]["descripcion"]
		                    })
		                });
					 }else{
					 	respuesta = data;	
					 }
					 resolve(respuesta);
					 */
					
				});
        	});
		}
	}
}]);