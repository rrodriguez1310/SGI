app.service('ProgramasService', ['$http', function($http) {

    this.listaProgramas = function() {
        var data = $http({
            method: 'GET',
            url: host + 'produccion_mcr_programas/programas_list',
        });
        return data;
    };
}]);