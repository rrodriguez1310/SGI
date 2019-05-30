app.controller('Preguntas', ['$scope', '$http', '$filter', 'preguntas', function($scope, $http, $filter, preguntas) {
    $scope.loader = true
    $scope.cargador = loader;


    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'pregunta', displayName: 'Pregunta' },
            { name: 'respuesta', displayName: 'Respuesta' },
            { name: 'prueba_id', displayName: 'Prueba' },
            { name: 'numero_pregunta', displayName: 'N° Pregunta' }

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
    preguntas.listaPreguntasGrid().success(function(data) {
        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnPreguntasDelete = false;
                    $scope.btnPreguntasEdit = false;
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
            window.location.href = host + "preguntas/delete/" + $scope.id
        };

        // $scope.hola = 'test' ;

    })
}]);