app.service('respuestas', ['$http', function($http) {

    this.listaRespuestas = function() {
        var data = $http({
            method: 'GET',
            url: host + 'respuestas/respuestas_list',
        });
        return data;
    };
}]);