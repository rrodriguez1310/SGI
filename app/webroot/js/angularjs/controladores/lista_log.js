app.controller('ListaLog', ['$scope', '$http', 'Flash', function($scope, $http, Flash) {
    $scope.hideGrid = true;
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {

        enableFiltering: true,
        showGridFooter: true,
        enableRowSelection: true,

        columnDefs: [
            { name: 'id' },
            { name: 'segnal' },
            { name: 'fechaOriginal' },
            { name: 'fecha' },
            { name: 'hora_inicio' },
            { name: 'duracion' },
            { name: 'programa' },
            { name: 'estado_programa' },
        ],

        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'log.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "Listado Log", style: 'headerStyle' },

        exporterPdfFooter: function(currentPage, pageCount) {
            return { text: currentPage.toString() + ' of ' + pageCount.toString(), style: 'footerStyle' };
        },
        exporterPdfCustomFormatter: function(docDefinition) {
            docDefinition.styles.headerStyle = { fontSize: 22, bold: true };
            docDefinition.styles.footerStyle = { fontSize: 10, bold: true };
            return docDefinition;
        },
        exporterPdfOrientation: 'portrait',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 500,
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };

    $scope.enviaFecha = function(fecha) {
        if (fecha != null) {
            $scope.hideGrid = false;
            $scope.loader = true;
            $http.get(host25 + 'log_programas/lista_log/' + fecha).success(function(data) {
                if (data.estado != 0) {
                    $scope.gridOptions.data = data;
                    $scope.loader = false;
                    $scope.hideGrid = false;
                } else {
                    $scope.hideGrid = true;
                    $scope.loader = true;
                    Flash.create('danger', data.mensaje, 'customAlert', duration = "5000");
                }

            });
        } else {
            console.log('debe seleccionar una fecha');
        }
    };
}]);