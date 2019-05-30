app.factory('bloquesFactory', function(){
	return {
		bloquesPorTipo : function(bloques, tipo){
			bloquesRespuesta = [];
			if(bloques.length != 0){
				angular.forEach(bloques, function (bloque){
					if(bloque.tipo == tipo){
						bloquesRespuesta.push(bloque);
					}
				});
			}
			return bloquesRespuesta;
		},
		bloquePorId : function(bloques, id){
			if(bloques.length!=0 && angular.isDefined(id)){
				angular.forEach(bloques, function (bloque){
					if(bloque.id == id){
						respuesta = bloque;
					}
				});
			}else{
				respuesta = "";
			}
			return respuesta;
		}
	};
})