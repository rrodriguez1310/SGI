app.factory('catalogacionRTiposFactory', function(){
	return {
		catalogacionRTiposPorId : function (tipos){
			respuesta = {};
			if(tipos.length != 0){
				angular.forEach(tipos, function(tipo){
					respuesta[tipo.id] = tipo;
				});
			}
			return respuesta;
		}
	};
});