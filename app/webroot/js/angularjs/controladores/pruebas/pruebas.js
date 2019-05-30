app.controller('Pruebas', ['$scope', '$http', '$filter', 'pruebas', function($scope, $http, $filter, pruebas) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'titulo', displayName: 'Título' },
            { name: 'descripcion', displayName: 'Descripción' },
            { name: 'numero_preguntas', displayName: 'Numero Preguntas' },
            { name: 'punt_max', displayName: 'Puntaje Maximo' },
            { name: 'punt_min', displayName: 'Puntaje Minimo' },
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
    pruebas.listaPruebas().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnPruebasDelete = false;
                    $scope.btnPruebasEdit = false;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.confirmacion = function() {
            window.location.href = host + "pruebas/delete/" + $scope.id
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