app.factory('listaCorreosFactory', ["$q", "listaCorreosService", function($q, listaCorreosService) {

	return {
		listaCorreos : function() {			
			return $q(function(resolve, reject) {
				listaCorreos = listaCorreosService.listaCorreos();
				listaCorreos.success(function(data, status, headers, config){
					 if(data["estado"]!=0){
		             	respuesta = [];
		             	angular.forEach(data["data"], function(valor, key){
		                    respuesta.push({
		                    	"id": valor["ListaCorreo"]["id"],
		                    	"nombre": valor["ListaCorreo"]["nombre"],
		                    	"descripcion": valor["ListaCorreo"]["descripcion"],
		                    	"tipo_nombre": valor["ListaCorreosTipo"]["nombre"],
		                    })
		                });
					 }else{
					 	respuesta = data;	
					 }
					 resolve(respuesta);
				});
        	});
		},
		listaCorreo : function(id){
			return $q(function(resolve, reject) {
				listaCorreo = listaCorreosService.listaCorreo(id);
				listaCorreo.success(function(data, status, headers, config){
					 if(data["estado"]!=0){
		             	respuesta = {};
	                    respuesta = {
	                    	"ListaCorreo": {
	                    		"id": data["data"]["ListaCorreo"]["id"],
	                    		'nombre':data["data"]["ListaCorreo"]["nombre"],
	                    		'descripcion':data["data"]["ListaCorreo"]["descripcion"],
	                    		'titulo': data["data"]["ListaCorreo"]["titulo"],
	                    		'mensaje': data["data"]["ListaCorreo"]["mensaje"],
	                    		'lista_correos_tipo_id': data["data"]["ListaCorreo"]["lista_correos_tipo_id"],
	                    		'estado': data["data"]["ListaCorreo"]["estado"]
	                    	}
	                    }
					 }else{
					 	respuesta = data;	
					 }
					 resolve(respuesta);
				});
        	});
		},
		listaCorreosTrabajadores : function(id){
			return $q(function(resolve, reject) {
				listaCorreoTrabajadores = listaCorreosService.listaCorreosTrabajadores(id);
				listaCorreoTrabajadores.success(function(data, status, headers, config){
					 if(data["estado"]!=0){
		             	respuesta = {};
	                    respuesta = {
	                    	"ListaCorreo": {
	                    		"id": data["data"]["ListaCorreo"]["id"],
	                    		'nombre':data["data"]["ListaCorreo"]["nombre"],
	                    		'descripcion':data["data"]["ListaCorreo"]["descripcion"],
	                    		'lista_correos_tipo_id': data["data"]["ListaCorreo"]["lista_correos_tipo_id"],
	                    		'lista_correos_mensaje_id': data["data"]["ListaCorreo"]["lista_correos_mensaje_id"],
	                    		'estado': data["data"]["ListaCorreo"]["estado"]
	                    	}
	                    };
	                    trabajadores = [];
	                    function trabajador(id, nombre, email, cargo){
	                    	this.id = id;
	                    	this.nombre = nombre;
	                    	this.email = email;
	                    	this.cargo = cargo;
	                    };
	                    angular.forEach(data.data.Trabajadore, function(valor, key){
	                    	trabajadores.push(new trabajador(valor["id"], valor["nombre"]+" "+valor["apellido_paterno"], valor["email"],valor["Cargo"]["nombre"]));
	                    });
	                    respuesta["Trabajadore"] = trabajadores;
					 }else{
					 	respuesta = data;	
					 }
					 resolve(respuesta);
				});
        	});
		},
		limpiaListaCorreosTrabajadores : function(trabajadores, listaCorreos){
			respuesta = []
			angular.forEach(trabajadores, function(trabajador, key){
				encontrado = false;
				angular.forEach(listaCorreos, function(correos, llave){
					if(trabajador.id == correos.id){
						encontrado = true;
					}
				});
				if(!encontrado){
					respuesta.push(trabajador);
				}
			});
			return respuesta;
		}
	}
}]);