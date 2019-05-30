app.service('listaEmpresasService', ["$http", function($http) {

	this.listaComentarios = function(id){
		promesa = $http.get(host25+'companies_comentarios/lista_comentarios_json/'+id)
		return promesa;
	};

}]);