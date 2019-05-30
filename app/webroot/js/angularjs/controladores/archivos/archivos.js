app.controller('Archivos', ['$scope', '$http', '$filter', 'archivos', function($scope, $http, $filter, archivos) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'leccion', displayName: 'Lección' },
            { name: 'ruta', displayName: 'Ruta' },
            { name: 'categorias_archivo_id', displayName: 'Categorias' },
            { name: 'nombre', displayName: 'Nombre' }
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
    archivos.listaArchivos().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnArchivosDelete = false;
                    $scope.btnArchivosEdit = false;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.confirmacion = function() {
            window.location.href = host + "archivos/delete/" + $scope.id
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