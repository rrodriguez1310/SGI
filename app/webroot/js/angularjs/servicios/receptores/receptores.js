app.service('ReceptoresService', ['$http', function($http) {

    this.listaReceptores = function() {
        var data = $http({
            method: 'GET',
            url: host + 'produccion_mcr_receptores/receptores_list',
        });
        return data;
    };
}]);