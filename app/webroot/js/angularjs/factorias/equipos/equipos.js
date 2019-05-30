app.factory('equiposFactory', function(){
	return {
		equiposPorId : function(equipos){
			respuesta = {};
			if(equipos.length !=0){
				angular.forEach(equipos, function (equipo){
					respuesta[equipo.id] = equipo;
				});
			}
			return respuesta;
		}
	};
});