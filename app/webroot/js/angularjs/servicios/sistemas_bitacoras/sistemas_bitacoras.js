app.service('sistemasBitacorasService', function ($http){
	this.registrarSistemasBitacora = function(formulario){
		return $http({
			method : "POST",
			url : host+"sistemas_bitacoras/registrar_sistemas_bitacora",
			data : $.param(formulario)
		});
	}
	this.sistemasBitacoras = function(){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/sistemas_bitacoras"
		});
	}
	this.sistemasBitacorasPorArea = function(areaId){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/sistemas_bitacoras_por_area",
			params : { areaId : areaId }
		});	
	}

	this.sistemasBitacora = function(id){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/sistemas_bitacora",
			params : {id : id}
		});
	}

	this.registroCierreBitacora = function(formulario){
		return $http({
			method : "POST",
			url : host+"sistemas_bitacoras/registro_cierre_bitacora",
			data : $.param(formulario)
		});
	}

	this.registroObservacionBitacora = function(formulario){
		return $http({
			method : "POST",
			url : host+"sistemas_bitacoras/registro_observacion_bitacora",
			data : $.param(formulario)
		});
	}

	this.dataReporte = function(){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/data_reporte"
		});
	}

	this.reporteArePorAnioJson = function(anio, area){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/reporte_area_por_anio_json",
			params : {anio : anio, area : area}
		});
	}

	this.areasBitacorasPorAnio = function (anio){
		return $http({
			method : "GET",
			url : host+"sistemas_bitacoras/areas_bitacoras_anio_json",
			params : {anio : anio}
		});
	};
});