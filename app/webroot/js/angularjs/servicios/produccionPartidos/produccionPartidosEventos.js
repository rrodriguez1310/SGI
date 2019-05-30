app.service('produccionPartidosEventos', function($http){
	this.listaEventos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_partidos_eventos/lista_eventos_json'
		});
		return data; 
	};

	this.enviarCorreoPartidos = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'produccion_partidos_eventos/enviar_correo_partidos',
			data: $.param(formulario)
		});
		return data;
	};

	this.dataCorreoInterno = function(formFecha){
		var data = $http({
			method: 'POST',
			url: host+'produccion_partidos_eventos/data_info_correo_json',
			data: $.param(formFecha)
		});
		return data;
	};
})