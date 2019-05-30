app.service('ratingMinutosService', ["$http", function($http) {

	this.minutos_rango_bandas_horas = function(inicio, final){
		parametros = {
			"inicio" : inicio, 
			"final": final 
		}
		var minutos = $http({
			method: 'GET',
			url: host+'rating_minutos/minutos_x_rango_bandas_horas',
			params: parametros
		});
		return minutos;
	};

	this.minutos_rango_minutos = function(inicio, final){
		parametros = {
			"inicio" : inicio, 
			"final": final 
		}
		var minutos = $http({
			method: 'GET',
			url: host+'rating_minutos/minutos_x_rango_minutos',
			params: parametros
		});
		return minutos;
	};

	this.semanasInformeBandas = function (fechas){
		return $http({
			method : "GET",
			url : host+"rating_minutos/semanas_informe_bandas",
			params : fechas
		});
	};
	this.acumulados = function(anio){
		return $http({
			method : "GET",
			url : host+"rating_minutos/acumulados",
			params : { anio : anio }
		});
	};
	this.graficosBandas = function(fecha){
		return $http({
			methid : "GET",
			url : host+"rating_minutos/grafico_bandas",
			params : { fecha : fecha }
		});
	}
	this.acumuladosSemanas = function(anio){
		return $http({
			method : "GET",
			url : host+"rating_minutos/acumulados_wtd",
			params : { anio : anio }
		});
	};
}]);