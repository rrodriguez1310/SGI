app.factory('catalogacionRResponsablesFactory', function(){
	return {
		responsablesPorId : function(responsables){
			respuesta = {};
			if(responsables.length!=0){
				angular.forEach(responsables, function (responsable){
					respuesta[responsable.id] = responsable;
				});
			}
			return respuesta;
		},
		responsablesPorUsuario : function(responsables){
			respuesta = {};
			if(responsables.length!=0){
				angular.forEach(responsables, function (responsable){
					respuesta[responsable.user_id] = responsable;
				});
			}
			return respuesta;
		}
	};
})