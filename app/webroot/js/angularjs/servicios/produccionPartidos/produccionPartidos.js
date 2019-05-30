app.service('ProduccionPartidos', function($http){
	this.listaEventos = function(){
		var data = $http({
			method: 'GET',
			url: host+'produccion_partidos/listaPartidos'
		});
		return data; 
	};
})