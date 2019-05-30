app.factory('listaCorreosTiposFactory', ["$q", "listaCorreosTiposService", function($q, listaCorreosTiposService) {

	return {
		listaCorreosTipos : function() {			
			return $q(function(resolve, reject) {
				tipos = listaCorreosTiposService.listaCorreosTipos();
				tipos.success(function(data, status, headers, config){
					 if(data["estado"]!=0){
		             	respuesta = [];
		             	angular.forEach(data["data"], function(valor, key){
		                    respuesta.push({
		                    	"id": valor["ListaCorreosTipo"]["id"],
		                    	"nombre": valor["ListaCorreosTipo"]["nombre"],
		                    	"descripcion": valor["ListaCorreosTipo"]["descripcion"]
		                    })
		                });
					 }else{
					 	respuesta = data;	
					 }
					 resolve(respuesta);
				});
        	});
		}
	}
}]);