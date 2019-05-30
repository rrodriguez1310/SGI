app.controller('Calificaciones', ['$scope', '$http', '$filter', 'calificaciones', function($scope, $http, $filter, calificaciones) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {
        columnDefs: [
            { name: 'id', displayName: 'Id', visible: false },
            { name: 'user_id', displayName: 'Usuario' },
            { name: 'calificacion', displayName: 'Puntaje' },
            { name: 'porcentaje', displayName: 'Porcentaje' },
            {
                name: 'estado',
                displayName: 'Estado',
                width: 180,
                cellTemplate: '<div class="ui-grid-cell-contents">{{(row.entity.estado=="Noiniciado") ? "No iniciado" :((row.entity.estado=="Encurso") ? "En curso" :((row.entity.estado=="Finalizada") ? "Finalizada" : "Eliminada") ) }}</div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                    return (grid.getCellValue(row, col) == 'Noiniciado') ? 'angular_aprobado_s' : ((grid.getCellValue(row, col) == 'Encurso') ? "angular_pendiente_g" : ((grid.getCellValue(row, col) == 'Finalizada') ? "angular_aprobado_g" : ""))
                }
            },
            { name: 'prueba_id', displayName: 'Prueba' },
            { name: 'video', displayName: 'Lección' },
            { name: 'created', displayName: 'Created' },
            { name: 'modified', displayName: 'Modified' }


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
    calificaciones.listaCalificaciones().success(function(data) {

        $scope.gridOptions.data = data;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope, function(row) {
            console.log('row.entity.estado', row.entity.estado);
            if (row.isSelected == true) {
                if (row.entity.id) {
                    $scope.id = row.entity.id;
                    $scope.btnCalificacionesDelete = false;
                    $scope.btnCalificacionesEdit = false;
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
            window.location.href = host + "calificaciones/delete/" + $scope.id
        };

    })
}]);