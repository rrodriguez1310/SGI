app.service('codigosPresupuestosService', function($http, Upload) {

    this.codigosPresupuestos = function() {
        return $http({
            method: "GET",
            url: host + "codigos_presupuestos/codigos_presupuestos"
        });
    };

    /*
    this.codigosPresupuestosAgnos = function(id) {
        console.log(id);
        return $http({
            method: "GET",
            params: { idAgno: id },
            url: host + "codigos_presupuestos/codigos_presupuestos_agno"
        });
    };
    */
    this.codigosPresupuestosAgnos = function(id) {
        console.log("servicio")
        console.log(id);
        var data = $http({
            params: { idAgno: id },
            method: 'GET',
            url: host + "codigos_presupuestos/codigos_presupuestos_agno"
        });
        return data;
    };

    this.codigosPresupuesto = function(idCodigoPresupuesto) {
        return $http({
            method: "GET",
            url: host + "codigos_presupuestos/codigos_presupuesto",
            params: { id: idCodigoPresupuesto },
        });
    };

    this.codigosPresupuestoRegistrar = function(formulario) {
        return $http({
            method: "POST",
            url: host + "codigos_presupuestos/codigos_presupuesto_registrar",
            data: $.param(formulario)
        });
    };
    this.delete = function(codigosPresupuestos) {
        return $http({
            method: "POST",
            url: host + "codigos_presupuestos/delete",
            data: $.param(codigosPresupuestos)
        });
    };
    this.cargaMasivaData = function(formulario) {
        return Upload.upload({
            method: "POST",
            url: host + "codigos_presupuestos/carga_masiva_data",
            fields: { year_id: formulario.CodigosPresupuesto.year_id },
            file: formulario.CodigosPresupuesto.archivo
        })
    };
});