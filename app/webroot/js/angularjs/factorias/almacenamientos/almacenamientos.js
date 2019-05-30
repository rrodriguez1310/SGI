app.factory('almacenamientosFactory', function(){
	return {
		almacenamientosPorTipo : function(almacenamientos, tipo){
			almacenamientosRespuesta = [];
			if(almacenamientos.length != 0){
				angular.forEach(almacenamientos, function (almacenamiento){
					if(almacenamiento.tipo == tipo){
						almacenamientosRespuesta.push(almacenamiento);
					}
				});
			}
			return almacenamientosRespuesta;
		}
	};
})