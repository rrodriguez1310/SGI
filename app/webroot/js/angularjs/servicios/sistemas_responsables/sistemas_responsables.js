app.service('sistemasResponsablesService', function ($http){
	this.sistemasResponsablesList = function(){
		return $http({
			method : "GET",
			url : host+"sistemas_responsables/sistemas_responsables_list"
		});
	};
});