app.service('evaluacionesAniosService', ["$http",'$location', 'Upload', function($http, $location, Upload) {
	this.evaluacionesAnios = function(){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_anios/listar_anios_json'
		});
		return data;
	}; 
	this.dataEvaluacionesAnios = function(){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_anios/data_add_anios_json'
		});
		return data;
	}; 
	this.addEvaluacionAnio = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'evaluaciones_anios/add_json',
			data: $.param(formulario)
		});
		return data;
	};
	this.dataEvaluacionesAniosEdit = function(id){
		var data = $http({
			method: 'GET',
			url: host+'evaluaciones_anios/edit_data_json/'+id
		});
		return data;
	}; 	
}]);
