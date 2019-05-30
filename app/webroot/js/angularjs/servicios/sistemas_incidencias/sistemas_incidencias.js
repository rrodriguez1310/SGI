app.service('sistemasIncidenciaService', function($http) {
    this.registrarSistemasIncidencia = function(formulario) {
        return $http({
            method: "POST",
            url: host + "sistemas_incidencias/registrar_sistemas_incidencias",
            data: $.param(formulario)
        });
    }

    this.sistemasIncidencias = function() {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/sistemas_incidencias"
        });
    }
    this.sistemasIncidenciasPorArea = function(areaId) {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/sistemas_incidencias_por_area",
            params: { areaId: areaId }
        });
    }

    this.sistemasIncidencia = function(id) {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/sistemas_incidencia",
            params: { id: id }
        });
    }


    this.registroCierreIncidencia = function(formulario) {
        return $http({
            method: "POST",
            url: host + "sistemas_incidencias/registro_cierre_incidencia",
            data: $.param(formulario)
        });
    }

    this.registroObservacionIncidencia = function(formulario) {
        return $http({
            method: "POST",
            url: host + "sistemas_incidencias/registro_observacion_incidencia",
            data: $.param(formulario)
        });
    }

    this.dataReporte = function(anio) {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/data_reporte",
            params: { anio: anio }
        });
    }

    this.reporteArePorAnioJson = function(anio, area) {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/reporte_area_por_anio_json",
            params: { anio: anio, area: area }
        });
    }

    this.areasIncidenciaPorAnio = function(anio) {
        return $http({
            method: "GET",
            url: host + "sistemas_incidencias/areas_incidencias_anio_json",
            params: { anio: anio }
        });
    };
});