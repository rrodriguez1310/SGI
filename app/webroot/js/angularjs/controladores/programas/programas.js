app.controller('Programas', ['$scope', '$http', '$filter', 'ProgramasService', function($scope, $http, $filter, ProgramasService) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'nombre', displayName: 'Nombre' },
            { name: 'tipo', displayName: 'Tipo' },

        ],
        enableGridMenu: true,
        enableSelectAll: false,
        exporterCsvFilename: 'myFile.csv',
        exporterMenuPdf: false,
        multiSelect: false,
        onRegisterApi: function(gridApi) {
            $scope.gridApi = gridApi;
        }
    };
    ProgramasService.listaProgramas().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnProduccionMcrProgramasDelete = false;
                    $scope.btnProduccionMcrProgramasEdit = false;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.confirmacion = function() {
            window.location.href = host + "produccion_mcr_programas/delete/" + $scope.id
        };
        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    })
}]);