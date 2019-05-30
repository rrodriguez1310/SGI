app.factory('areasFactory', ['$http', function ($http) {

	return {
		areasGerencia : function(areas, idGerencia) {
			areasArray = [];
			angular.forEach(areas, function (area){
				if(area.gerencia_id==idGerencia){
					areasArray.push(area);
				}
			})
			return areasArray;
		}
	}
}]);