app.service('evaluacionesService', ["$http",'$location', 'Upload', function($http, $location, Upload) {

	this.datosNuevaEvaluacion = function(idTrabajador){
		var data = $http({
			method: 'POST',
			url: host25+'evaluaciones_trabajadores/add_json/'+idTrabajador
		});
		return data;
	};

	this.addEvaluacion = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_trabajadores/add_evaluacion',
			data: $.param(formulario)
		});
		return data;
	};

	this.getEvaluacion = function(idEvaluacion){
		var data = $http({
			method: 'POST',
			url: host25+'evaluaciones_trabajadores/edit_json/'+idEvaluacion
		});
		return data;
	};

	this.subirEvaluacion = function(archivo, formulario){		
        var data = Upload.upload({
        	file 	: archivo,
            fields	: formulario,
            url		: host+'evaluaciones_trabajadores/subir_evaluacion'
        });
        return data;
	};

	this.getEvaluacionesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_trabajadores/evaluaciones_actuales_json/'
		});
		return data;
	};

	this.getEvaluacionesFinal = function(anio){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_trabajadores/evaluaciones_final_json/'+anio
		});		
		return data;
	};

	this.updateObjetivos = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_objetivos/add_objetivos',
			data: $.param(formulario)
		});
		return data;
	};

	this.dataGraficoEvaluaciones = function(anio){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_trabajadores/evaluaciones_graficos_json',
			data: $.param(anio)
		});
		return data;
	};
 
}]);
