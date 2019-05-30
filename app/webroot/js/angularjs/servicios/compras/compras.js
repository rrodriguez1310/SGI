app.service('comprasServices', ['$http', '$location', function($http, $location) {
    this.editCodigoSap = function(idCompras, codigoSap) {
        var data = $http({
            method: 'GET',
            params: { comprasId: idCompras, numeroSap: codigoSap },
            url: host25 + 'compras/edit_codigo_sap'
        });
        return data;
    };

    this.listaAprobadores = function(idCompras, codigoSap) {
        var data = $http({
            method: 'GET',
            url: host25 + 'compras/lista_email_json'
        });
        return data;
    };

    this.listaCodigosCortos = function() {
        var data = $http({
            method: 'GET',
            url: host25 + 'compras/codigos_cortos'
        });
        return data;
    };

    this.editarAprobador = function(id, email, tipo, aprobador) {
        var data = $http({
            method: 'get',
            params: { getId: id, getEmail: email, getTipo: tipo, getOperador: aprobador },
            url: host25 + 'compras/lista_aprobadores_editar'
        });
        return data;
    };

    this.aprobadorAdd = function(id, email, tipo, aprobador) {
        var data = $http({
            method: 'get',
            params: { getId: id, getEmail: email, getTipo: tipo, getOperador: aprobador },
            url: host25 + 'compras/aprobadores_add'
        });
        return data;
    }

    this.aprobadorDelete = function(id) {
        var data = $http({
            method: 'get',
            params: { getId: id },
            url: host25 + 'compras/aprobadores_delete'
        });
        return data;
    }

    this.editCodigoPresupuestario = function(id) {
        var urlEmpresa = $location.absUrl().split('/');
        corte = urlEmpresa.length - 1
        var data = $http({
            method: 'get',
            params: { getId: urlEmpresa[corte] },
            url: host25 + 'compras/listar_compras_productos'
        });
        return data;
    }

    this.editaCodigoProducto = function(idProducto, agno, codigo) {
        var data = $http({
            method: 'get',
            params: { getId: idProducto, getAgno: agno, getCodigo: codigo },
            url: host25 + 'compras/edit_codigo_presupuestario'
        });
        return data;
    }

    this.listaFacturasAprobadas = function() {
        var data = $http({
            method: 'GET',
            url: host25 + 'compras_reportes/json_facturas_aprobadas'
        });
        return data;
    };

    this.listaDetallePresupuesto = function(anio, general) {
        var data = $http({
            method: 'GET',
            url: host25 + 'compras_reportes/presupuesto_json/' + anio + '/' + general
        });
        return data;
    };

    this.listaPresupuestoGrafico = function(codigos) {

        var data = $http({
            method: 'GET',
            params: { famPresupuesto: codigos.famPresupuesto, codPresupuesto: codigos.codPresupuesto, anioPresupuesto: codigos.anioPresupuesto, general: codigos.general },
            url: host25 + 'compras_reportes/grafico_presupuesto_json'
        });
        return data;
    };

    this.misCompras = function() {
        var data = $http({
            method: 'GET',
            url: host25 + 'compras/mis_compras_json'
        });
        return data;
    };


}]);