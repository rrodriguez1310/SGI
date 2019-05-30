app.service('objetivosService', ["$http",'$location', 'Upload', function($http, $location, Upload) {

	this.listadoObjetivos = function(){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_objetivos/listado_objetivos/'
		});
		return data;
	};

	this.listadoCalibrar = function(){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_objetivos/listado_calibrador/'
		});
		return data;
	};

	this.objetivosConsolidado = function(anio){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_objetivos/objetivos_consolidado_json/'+anio
		});
		return data;
	};

	this.getObjetivos = function(idTrabajador){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_objetivos/add_json/'+idTrabajador
		});
		return data;
	};

	this.addObjetivos = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_objetivos/add_objetivos',
			data: $.param(formulario)
		});
		return data;
	};

	this.getEvaluacion = function(idEvaluacion, etapaObj){
		if(!angular.isDefined(etapaObj)) etapaObj = 1;
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_objetivos/edit_json/'+idEvaluacion+'/'+etapaObj
		});
		return data;
	};

	this.subirEvaluacion = function(archivo, formulario){		
        var data = Upload.upload({
        	file 	: archivo,
            fields	: formulario,
            url		: host+'evaluaciones_objetivos/subir_evaluacion'
        });
        return data;
	};

}]);
