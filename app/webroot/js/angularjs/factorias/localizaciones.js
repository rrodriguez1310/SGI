app.factory('localizacionesFactory', function() {
	return {
		direcciones : function(localizaciones) {	
			respuesta = {};
			 if(localizaciones.estado==1){
                angular.forEach(localizaciones.data, function(valor, key){
                    respuesta[valor["direccion"]] = {
                    	"id": valor["id"],
                    	"direccion": valor["direccion"]
                    }
                });	
			 }
			 return respuesta;
		}
	}
});