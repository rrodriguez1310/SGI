app.service('sistemasResponsablesIncidenciasService', function($http) {
    this.sistemasResponsablesList = function() {
        return $http({
            method: "GET",
            url: host + "sistemas_responsables_incidencias/sistemas_responsables_list"
        });
    };
});