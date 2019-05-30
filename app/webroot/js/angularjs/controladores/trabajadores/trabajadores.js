app.controller('ListaTrabajadores', ['$scope', 'trabajadoresService', 'Flash', '$http', '$filter', 'uiGridConstants', function($scope, trabajadoresService, Flash, $http, $filter, uiGridConstants) {
    $scope.tablaDetalle = false;
    $scope.loader = true;
    $scope.cargador = loader;

    $scope.gridOptions = {
            enableFiltering: false,
            useExternalFiltering: true,
            flatEntityAccess: true,
            showGridFooter: true,
            enableRowSelection: false,
            enableRowHeaderSelection: true,
            multiSelect: false,
            // rowHeight:50,
            onRegisterApi: function(gridApi) {
                $scope.gridApi = gridApi;
            },

            enableGridMenu: true,
            enableSelectAll: true,
            exporterCsvFilename: 'Todos_Sap.csv',
            exporterPdfDefaultStyle: { fontSize: 9 },
            exporterPdfTableStyle: { margin: [30, 30, 30, 30] },
            exporterPdfTableHeaderStyle: { fontSize: 10, bold: true, italics: true, color: 'red' },
            exporterPdfHeader: { text: "Documento", style: 'headerStyle' },
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
        },

        $scope.gridOptions.columnDefs = [
            { name: 'Id', displayName: 'Id', enableCellEdit: false, visible: false },
            { name: 'Nombre', displayName: 'Nombre', sort: { direction: uiGridConstants.ASC, ignoreSort: true }, enableCellEdit: false },
            { name: 'ApellidoPaterno', displayName: 'A.Paterno', enableCellEdit: false },
            { name: 'ApellidoMaterno', displayName: 'A.Materno', enableCellEdit: false },
            { name: 'Gerencia', displayName: 'Gerencias', enableCellEdit: false },
            { name: 'Email', displayName: 'Email CDF', enableCellEdit: true, cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) { return 'fondo_editable' } },
            { name: 'Anexo', displayName: 'Anexo', enableCellEdit: true, cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) { return 'fondo_editable' } },
            { name: 'MovilCorporativo', displayName: 'Móvil CDF', enableCellEdit: true, cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) { return 'fondo_editable' } },
        ];

    $scope.msg = {};

    $scope.gridOptions.onRegisterApi = function(gridApi) {
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
            $scope.msg.lastCellEdited = { "id": rowEntity.Id, "columna": colDef.name, "valor": newValue };
            $scope.$apply();
        });
    };

    trabajadoresService.trabajadoresListadoCorto().success(function(data) {
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;

        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });

    $scope.$watch("msg.lastCellEdited", function(valorAeditar) {
        if (angular.isUndefined(valorAeditar) == false) {
            trabajadoresService.editaTrabajadorSistema(valorAeditar).success(function(mensaje) {
                if (mensaje.Error === 0) {
                    Flash.create('danger', mensaje.mensaje, 'customAlert');
                } else {
                    Flash.create('success', mensaje.mensaje, 'customAlert');
                }
            })
        }
    });
}]);
