//servicetransmisionJson
app.service('TransmisionService', function($http) {
    this.transmisionListaJson = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/transmision_lista_json'
        });
        return data;
    };
    this.listaPruebas = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/add_informe_senales',
            data: $.param(formulario)
        });
        return data;
    };
    this.transmisionListaEnvioJson = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/transmision_lista_envio_json'
        });
        return data;
    };
    this.transmisionListaExcelJson = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/transmision_lista_excel_json'
        });
        return data;
    };
    this.transmisionLeerExcelJson = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/transmision_leer_excel_json'
        });
        return data;
    };
    this.transmisionGeneraExcel = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/excel'
        });
        return data;
    };
    this.transmisionLeerCsvJson = function(archivo) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/transmision_leer_csv_json/' + archivo
        });
        return data;
    };
    this.consolidaCsv = function(datos) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/consolidar_csv',
            data: datos,
            headers: {
                'Content-type': 'application/json'
            }
        });
        return data;
    };
    this.editTransmision = function(id) {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/edit_transmision/' + id,
        });
        return data;
    };
    this.editarTransmisionGuardar = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/editar_transmision_guardar',
            data: $.param(formulario)
        });
        return data;
    };
    this.addTransmision = function(id) {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/add_transmision/' + id,
        });
        return data;
    };
    this.listaSenales = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/informe_senales',
        });
        return data;
    };
    this.addTransmisionGuardar = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/add_transmision_guardar',
            data: $.param(formulario)
        });
        return data;
    };
    this.enviarCorreoTransmisiones = function(formulario) {
        var data = $http({
            method: 'POST',
            url: host + 'transmision_partidos/enviar_correo_transmisiones',
            data: $.param(formulario)
        });
        return data;
    };
    this.transmisionReporteListaJson = function() {
        var data = $http({
            method: 'GET',
            url: host + 'transmision_partidos/reporte_datos'
        });
        return data;
    };
})