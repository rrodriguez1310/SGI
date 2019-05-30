app.service('tipoRequerimiento', function($http){
	this.listaRequerimientos = function(){
		var data = $http({
			method: 'GET',
			url: host+'catalogacion_r_tipos/requerimientos_tipos_list'
		});
		return data; 
	};
})