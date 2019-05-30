app.service('produccionPartidosOptas', function($http, $sce){
	this.dataPartidos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_partidos_optas/lista_opta_json'
		});
		return data; 
    };

    this.fixtureOpta = function(idSeason, idCompetition){
        var data = $http({
            method: 'GET',
            url: host+'produccion_partidos_optas/archivo_opta_xml/'+ idSeason + '/' + idCompetition
        });
		return data 
    }; 

    this.guardarDataPartidos = function(form) {
        var data = $http({
			method: 'POST',
			url: host+'produccion_partidos_optas/guardar_data_opta',
			data: $.param(form)
        });
        return data;        
    };

})