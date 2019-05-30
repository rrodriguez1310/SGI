app.factory('soportesFactory', function(){
	return {
		soportesPorTipo : function(soportes, tipo){
			soportesRespuesta = [];
			if(soportes.length != 0){
				angular.forEach(soportes, function (soporte){
					if(soporte.tipo == tipo){
						soportesRespuesta.push(soporte);
					}
				});
			}
			return soportesRespuesta;
		},
		soportesPorId : function(soportes){
			respuesta = {};
			if(soportes.length!=0){
				angular.forEach(soportes, function (soporte){
					respuesta[soporte.id] = soporte;
				});
			}
			return respuesta;
		}
	};
})