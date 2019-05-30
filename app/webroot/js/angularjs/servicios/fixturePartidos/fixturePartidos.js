app.service('FixturePartidos', function($http){
	this.listaPartidos = function(){
		var data = $http({
			method: 'GET',
			url: host+'fixture_partidos/lista_fixtures_json'
		});
		return data; 
	};
})