app.factory('copiasFactory', function(){
	return {
		copiasPorTipo : function(copias, tipo){
			copiasRespuesta = [];
			if(copias.length != 0){
				angular.forEach(copias, function (copia){
					if(copia.tipo == tipo){
						copiasRespuesta.push(copia);
					}
				});
			}
			return copiasRespuesta;
		},
		copiasPorId : function (copias){
			respuesta = {};
			if(copias.length!=0){
				angular.forEach(copias, function(copia){
					respuesta[copia.id] = copia;
				});
			}
			return respuesta;
		}
	};
})