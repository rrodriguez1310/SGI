app.service('senalesService', function($http){
	this.listaSenales = function(){
		var data = $http({
			method: 'GET',
			url: host+'transmision_senales/senales_list'
		});
		return data; 
	};
})