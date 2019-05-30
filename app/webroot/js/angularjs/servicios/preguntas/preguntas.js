app.service('preguntas', ['$http', function($http) {
    this.listaPreguntas = function() {
        var data = $http({
            method: 'GET',
            url: host + 'preguntas/preguntas_list',
        });
        return data;
    };
    this.addCalificaciones = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'preguntas/add_calificaciones',
            data: $.param(formulario)
        });
        return data;
    };
    this.listaPreguntasGrid = function() {
        var data = $http({
            method: 'GET',
            url: host + 'preguntas/preguntas_list_grid',
        });
        return data;
    };

}]);