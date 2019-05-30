app.factory('cargosFactory', ['$http', function ($http) {

	return {
		cargosArea : function(cargos, idArea) {
			cargosArray = [];
			angular.forEach(cargos, function (cargo){
				if(cargo.area_id==idArea){
					cargosArray.push(cargo);
				}
			})
			return cargosArray;
		}
	}
}]);