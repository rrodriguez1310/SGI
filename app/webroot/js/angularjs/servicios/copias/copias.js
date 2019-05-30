app.service('copiasService', function ($http){
	this.copiasList = function(){
		return $http({
			method: "GET",
			url: host+"copias/copias_list"
		});
	}
});