app.service('ProduccionPartidosChileFilms', function($http){
	this.listaEventos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_partidos/listaChileFilms'
		});
		return data; 
	};
})