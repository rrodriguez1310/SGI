app.factory("factoria", function(){
	return {
		arregloPorPropiedad : function(arreglo, propiedad){
			respuesta = [];
			if(arreglo.length!=0){
				angular.forEach(arreglo, function (datos){
					respuesta[datos[propiedad]] = datos;
				});
			}
			return respuesta;
		},
		calculoDifMilisecADiasMinSec : function(fechaUno, fechaDos){
			var msecPerMinute = 1000 * 60;
			var msecPerHour = msecPerMinute * 60;
			var msecPerDay = msecPerHour * 24;
			var interval = fechaUno - fechaDos;
			
			var days = Math.floor(interval / msecPerDay );
			interval = interval - (days * msecPerDay );

			var hours = Math.floor(interval / msecPerHour );
			interval = interval - (hours * msecPerHour );

			var minutes = Math.floor(interval / msecPerMinute );
			interval = interval - (minutes * msecPerMinute );

			var seconds = Math.floor(interval / 1000 );			
			return {
				dias : days,
				horas : hours,
				minutos : minutes
			};
		},
		deleteCreatedModifiedDosNiveles : function(queryCake){
			if(queryCake.length!=0){
				angular.forEach(queryCake, function (datos, modelo){
					delete queryCake[modelo].created;
					delete queryCake[modelo].modified;
					if(angular.isArray(queryCake[modelo])){
						angular.forEach(queryCake[modelo], function (valores, key){
							delete queryCake[modelo][key].created;
							delete queryCake[modelo][key].modified;
						});
					}
				});	
			}
			return queryCake;
			
		}
	}
});