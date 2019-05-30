app.controller('collaborator', ['$scope', '$http', '$filter', 'collaboratorService', function($scope, $http, $filter, collaboratorService) {
    $scope.trabajador_id = 0;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.gridOptions = {
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableFiltering: false,
        useExternalFiltering: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
 
    collaboratorService.recognitionList().success(function(response){
        //console.log(response);
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
            $scope.imagedir =row.entity.imagedir;
            if(row.isSelected == true){
                $scope.id = row.entity.trabajador_id;
                $scope.boton = true;
            }else{
                $scope.boton = false;
                $scope.id = 0;
            }
            
        });

        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = response;
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    
    });

    $scope.gridOptions = {
        columnDefs: [
           //{ name: 'id', displayName: 'ID', visible = false },
           { name: 'fecha', displayName: 'Fecha:' },
           { name: 'colaborador', displayName: 'Colaborador:' },
           { name: 'conducta', displayName: 'Valores:' },
           { name: 'subconduta', displayName: 'Comportamientos:' },
           { name: 'descripcion', displayName: 'Descripción:' },
           { name: 'ingresos', displayName: 'Puntos Asignados:' },
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

    $scope.confirmacion = function() {
        window.location.href = host + "recognitionSubconducts/delete/" + $scope.id
    };


}]);