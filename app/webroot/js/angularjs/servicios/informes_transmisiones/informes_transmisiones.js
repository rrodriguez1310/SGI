app.service('informeTransmisiones', ['$http', function($http) {

    this.listaInformes = function() {
        var data = $http({
            method: 'GET',
            url: host + 'produccion_mcr_informes/informes_list',
        });
        return data;
    };
    this.addInformes = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'produccion_mcr_informes/add_informe_senales',
            data: $.param(formulario)
        });
        return data;
    };
    this.viewInformes = function(id) {
        var data = $http({
            method: 'GET',
            url: host + 'produccion_mcr_informes/informes_view/' + id,
        });
        return data;
    };
    this.editarTransmisionGuardar = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'produccion_mcr_informes/informes_edit',
            data: $.param(formulario)
        });
        return data;
    };
    this.addInformeTransmision = function(id) {
        var data = $http({
            method: 'GET',
            url: host + 'produccion_mcr_informes/add_informe_senales',
        });
        return data;
    };
}]);