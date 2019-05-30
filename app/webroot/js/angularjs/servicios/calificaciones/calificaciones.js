app.service('calificaciones', ['$http', function($http) {

    this.listaCalificaciones = function() {
        var data = $http({
            method: 'GET',
            url: host + 'calificaciones/calificaciones_list',
        });
        return data;
    };

}]);