app.service('archivos', ['$http', function($http) {

    this.listaArchivos = function() {
        var data = $http({
            method: 'GET',
            url: host + 'archivos/archivos_list',
        });
        return data;
    };
}]);