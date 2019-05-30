app.factory('trabajadoresFactory', ["$q", "trabajadoresService", function($q, trabajadoresService) {

	return {
		trabajadoresEmail : function() {			
			return $q(function(resolve, reject) {
				trabajadores = trabajadoresService.trabajadoresListado();
				trabajadores.success(function(data, status, headers, config){
					 if(data["estado"]!=0){
		             	respuesta = [];
		             	angular.forEach(data["data"], function(valor, key){
		             		if(valor["estado"]=="Activo")
		             		{
		             			if(valor["email"]){
			             			respuesta.push({
				             			"id": valor["id"],
				             			"nombre": valor["nombre"]+" "+valor["apellido_paterno"],
				             			"email": valor["email"],
				             			"cargo": valor["nombreCargo"]
				             		});
				             	}
		             		}
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
	                    		'lista_correos_tipo_id': data["data"]["ListaCorreo"]["lista_correos_tipo_id"],
	                    		'lista_correos_mensaje_id': data["data"]["ListaCorreo"]["lista_correos_mensaje_id"],
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
		trabajadoresList : function(trabajadores){
			trabajadoresArray = [];
			angular.forEach(trabajadores, function(data){
				trabajadoresArray.push({
					id : data.id,
					nombre : data.nombre+" "+data.apellido_paterno
				});
			});
			return trabajadoresArray;
		},
		trabajadoresTiposDocumentosList : function(tiposDocumentos){
			tiposDocumentosArray = [];
			angular.forEach(tiposDocumentos, function(tipoDocumento){
				if(tipoDocumento.tipo == 2 || tipoDocumento.tipo == 3){
					tiposDocumentosArray.push(tipoDocumento);
				}
			});
			return tiposDocumentosArray;
		},
		tipoMonedasSalud : function(tiposMonedas){
			tiposMonedasArray = [];
			angular.forEach(tiposMonedas, function(tiposMoneda){
				if(tiposMoneda.id == 1 || tiposMoneda.id == 6){
					tiposMonedasArray.push(tiposMoneda);
				}
			});
			return tiposMonedasArray;
		},
		dimensionesTrabajador : function(dimensiones){
			dimensionesArray = [];
			angular.forEach(dimensiones, function(dimensione){
				if(dimensione.TiposDimensioneId == 1){
					if(dimensione.Codigo.toString().slice(-3) == "800"){
						dimensionesArray.push({
							id: dimensione.Id,
							codigo: dimensione.Codigo,
							nombre: dimensione.Nombre
						});	
					}
				}
			});
			return dimensionesArray;
		},
		reportePendientes : function(datos){
			reporteArray = [];
			tiposDocumentos = {};
			angular.forEach(datos[1]["data"]["data"], function (tiposDocumento){
				tiposDocumentos[tiposDocumento["id"]] = tiposDocumento["nombre"];
			});
			angular.forEach(datos[0]["data"]["data"], function(trabajador){
				//console.log(trabajador);
				if(trabajador["Trabajadore"]["estado"]!="Prospecto"){
					if(trabajador["Trabajadore"]["foto"] == "photo.png"){
						trabajadoreFoto = {
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Sin Foto"
						};
						reporteArray.push(trabajadoreFoto);
					}
					if(trabajador["Documento"].length == 0){
						trabajadoreDocumentacion = {
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Sin ninguna Documentación"
						};
						reporteArray.push(trabajadoreDocumentacion);
					}else{
						documentacion = [];
						sinArchivo = [];
						angular.forEach(trabajador["Documento"], function (documento){
							switch(documento["tipos_documento_id"]){
								case 1 :
								case 3 :
								case 4 : 
								case 23 :
								case 24 :
								case 25 :
									documentacion.push("Documento contrato");
								break;
							}
							if(!angular.isString(documento["ruta"])){
								sinArchivo.push({
									fecha : documento["fecha_inicial"],
									tipoDocumento : tiposDocumentos[documento["tipos_documento_id"]],

								});
							}
						});
						if(documentacion.length==0){
							trabajadoreContrato = {
								id : trabajador["Trabajadore"]["id"],
								nombre : trabajador["Trabajadore"]["nombre"],
								apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
								apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
								tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
								estado : trabajador["Trabajadore"]["estado"],
								pendiente : "Sin Contrato"
							};
							reporteArray.push(trabajadoreContrato);
						}
						if(sinArchivo.length!=0){
							trabajadoreArchivo = {
								id : trabajador["Trabajadore"]["id"],
								nombre : trabajador["Trabajadore"]["nombre"],
								apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
								apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
								tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
								estado : trabajador["Trabajadore"]["estado"],
								pendiente : "Sin documento adjunto"
							};
							reporteArray.push(trabajadoreArchivo);
						}
					}
					if(!angular.isNumber(trabajador["Trabajadore"]["cargo_id"])){
						trabajadoreCargo = {
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Sin Cargo"
						};
						reporteArray.push(trabajadoreCargo);
					}
					if(!angular.isNumber(trabajador["Trabajadore"]["jefe_id"])){
						trabajadoreJefe = {
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Sin Jefe"
						};
						reporteArray.push(trabajadoreJefe);
					}else{
						if(trabajador["Jefe"]["estado"] == 0){
							if(trabajador["Trabajadore"]["estado"]!="Retirado"){
								trabajadoreJefeEstado = {
									id : trabajador["Trabajadore"]["id"],
									nombre : trabajador["Trabajadore"]["nombre"],
									apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
									apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
									tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
									estado : trabajador["Trabajadore"]["estado"],
									pendiente : "Sin Jefe activo"
								};
								reporteArray.push(trabajadoreJefeEstado);	
							}
						}
					}
					if(trabajador["User"].length==0 && trabajador["Trabajadore"]["estado"] == "Activo"){
						reporteArray.push({
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Activo sin usuario SGI"
						});
					}
					if(trabajador["User"].length!=0 && trabajador["Trabajadore"]["estado"] == "Retirado" && trabajador["User"]["estado"] == 1){
						reporteArray.push({
							id : trabajador["Trabajadore"]["id"],
							nombre : trabajador["Trabajadore"]["nombre"],
							apellido_paterno : trabajador["Trabajadore"]["apellido_paterno"],
							apellido_materno : trabajador["Trabajadore"]["apellido_materno"],
							tipo_contrato : (angular.isString(trabajador["TipoContrato"]["nombre"])) ? trabajador["TipoContrato"]["nombre"] : "",
							estado : trabajador["Trabajadore"]["estado"],
							pendiente : "Retirado con usuario SGI"
						});
					}
				}
			});
			return reporteArray;
		},
		monedaSalud : function(monedasList){
			monedas = {};
			angular.forEach(monedasList, function (moneda){
				monedas[moneda.id] = moneda.nombre;
			});
			return monedas
		}
	}
}]);