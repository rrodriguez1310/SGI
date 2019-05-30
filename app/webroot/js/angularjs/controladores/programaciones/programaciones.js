app.controller('ConciliacionProgramacion', ['$scope', '$http', 'Flash', function($scope, $http, Flash) {

    $scope.gridOptions = {
        enableFiltering: true,
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
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

    $scope.gridOptionsUno = {
        enableFiltering: true,
        enableGridMenu: true,
        enableSelectAll: true,
        exporterCsvFilename: 'myFile.csv',
        exporterPdfDefaultStyle: { fontSize: 9 },
        exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
        exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
        exporterPdfHeader: { text: "My Header", style: 'headerStyle' },
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


    $scope.gridOptionsUno.columnDefs = [
        { name: 'id', displayName: 'Id', enableCellEdit: false },
        { name: 'fecha', displayName: 'Fecha', enableCellEdit: false },
        { name: 'hora_inicio', displayName: 'Inicio', enableCellEdit: false },
        { name: 'duracion', displayName: 'Duración', enableCellEdit: false },
        {
            name: 'nombre',
            displayName: 'Titulo',
            enableCellEdit: false,
            cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {

                if (grid.getCellValue(row, col).substr(0, 6) == "HDPRES") {
                    return 'angular_aprobado_g';
                }
            }
        },
        { name: 'dia_tv', displayName: 'Dia Tv', enableCellEdit: false },
        { name: 'estado', displayName: 'Estado', enableCellEdit: false },
        { name: 'nombre_canal', displayName: 'Señal', enableCellEdit: false },
    ];
    $scope.gridOptions.columnDefs = [
        { name: 'id', displayName: 'Id', enableCellEdit: false },
        { name: 'log_programa_id', displayName: 'Id-Log', enableCellEdit: true },
        { name: 'fecha_full', displayName: 'Fecha', enableCellEdit: false },
        { name: 'hora', displayName: 'Hora', enableCellEdit: false },
        { name: 'nombre', displayName: 'Titulo', enableCellEdit: false },
        { name: 'signal', displayName: 'Señal', enableCellEdit: false }
    ];

    $scope.enviaFecha = function(form) {

        if (form.fecha && form.signal) {
            $http.get(host25 + 'programaciones/listaProgramacion/' + form.fecha + '/' + form.signal).success(function(data) {
                if (data.length > 0) {
                    $scope.gridOptions.data = data;
                } else {
                    alert("No hay informacion de programacion para este dia");
                }
            });

            $http.get(host25 + 'programaciones/listaLog/' + form.fecha + '/' + form.signal).success(function(data) {
                if (data.length > 0) {
                    $scope.gridOptionsUno.data = data;

                } else {
                    alert("No hay informacion de Log para este dia");
                }
            });
        }
    };

    $scope.gridOptions.onRegisterApi = function(gridApi) {
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {

            if (rowEntity.id != "" && newValue != "") {
                $http.get(host25 + 'programaciones/edit/' + rowEntity.id + '/' + newValue).success(function(data) {
                    if (data.Error === 1) {
                        Flash.create('success', data.Mensaje, 'customAlert');
                    } else {
                        Flash.create('danger', data.Mensaje, 'customAlert');
                    }
                });
            } else {
                alert("No se puede registrar falta información")
            }
            $scope.$apply();
        });
    };
}]);