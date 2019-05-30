app.service('sistemaPensionesService', ['$http', function ($http){
	
	this.sistemaPensionesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'sistema_pensiones/sistema_pensiones_list',
		});		
		return data;
	};
}])