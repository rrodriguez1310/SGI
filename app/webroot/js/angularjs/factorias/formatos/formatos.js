app.factory('formatosFactory', function(){
	return {
		formatoPorTipo : function(formatos, tipo){
			formatosRespuesta = [];
			if(formatos.length != 0){
				angular.forEach(formatos, function (formato){
					if(formato.tipo == tipo){
						formatosRespuesta.push(formato);
					}
				});
			}
			return formatosRespuesta;
		},
		formatoPorId : function(formatos, id){
			if(formatos.length!=0 && angular.isDefined(id)){
				angular.forEach(formatos, function (formato){
					if(formato.id == id){
						respuesta = formato;
					}
				});
			}else{
				respuesta = "";
			}
			return respuesta;
		},
		formatosPorId : function(formatos){
			respuesta = {};
			if(formatos.length!=0){
				angular.forEach(formatos, function(formato){
					respuesta[formato.id] = formato;
				});
			}
			return respuesta;
		}
	};
})