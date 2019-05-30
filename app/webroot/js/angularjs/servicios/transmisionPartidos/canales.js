app.service('canalesService', function($http){
	this.listaCanales = function(){
		var data = $http({
			method: 'GET',
			url: host+'transmision_canales/canales_list'
		});
		return data; 
	};
})