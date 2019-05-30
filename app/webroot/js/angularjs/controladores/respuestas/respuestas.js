app.controller('Respuestas', ['$scope', '$http', '$filter', 'respuestas', function($scope, $http, $filter, respuestas) {
    $scope.loader = true
    $scope.cargador = loader;


    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'opcion_letra', displayName: 'Letra' },
            { name: 'opcion_text', displayName: 'Respuesta' },
            { name: 'pregunta_id', displayName: 'Pregunta' }
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
    respuestas.listaRespuestas().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnRespuestasDelete = false;
                    $scope.btnRespuestasEdit = true;
                    $scope.boton = true;
                }
            } else {
                $scope.boton = false;
            }
        });
        $scope.refreshData = function(termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };

        $scope.confirmacion = function() {
            window.location.href = host + "respuestas/delete/" + $scope.id
        };

    })
}]);