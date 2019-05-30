app.service('induccionPantallasService', ['$http', function($http){
	/*Servicio con relacion a la vista del index*/
	this.induccionList = function(idTrabajador){
		var data = $http({
			method: 'GET',
			url: host+'induccionPantallas/index_json',
			params: { idTrabajador }
		});
		return data; 
	};

	/* Servicios con relacion directa a la vista contenidos*/ 

	//Retorna los contenidos activos por lección que se mostraran en el visor
	this.getContenidosLeccion = function(leccion_id){
		var data = $http({
			method: 'GET',
			url: host+'induccionPantallas/getContenidos_json',
			params: { leccion_id }
		});
		return data;
	};

	//Verifica el progreso de contenidos, retorna 1 si el contenido fue terminado
	this.getContenidosProgreso = function(leccion_id,induccion_contenido_id, trabajador_id){
		var data = $http({
			method: 'GET',
			url: host+'induccionPantallas/getContenidos',
			params : { leccion_id, induccion_contenido_id, trabajador_id }
		});
		return data;
	};

	//Gurda en db el progreso de los contenidos por leccion
	this.insertContenidosProgreso = function(leccion_id,induccion_contenido_id, trabajador_id){
		var data = $http({
			method: 'POST',
			url: host+'induccionPantallas/avance',
			params: { leccion: leccion_id, contenido: induccion_contenido_id, trabajador_id: trabajador_id }
		});
		return data;
	};

	/*Servicio para generar el reporte */
		this.induccionReports = function(){
			var data = $http({
				method: 'GET',
				url: host+'induccionPantallas/reports_json',
			});
			return data;
		};

}]);