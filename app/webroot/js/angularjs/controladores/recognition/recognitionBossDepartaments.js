app.controller('bossDepartaments', ['$scope', '$http', '$filter', 'bossDepartamentsService', function($scope, $http, $filter, bossDepartamentsService) {
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

    

    bossDepartamentsService.recognitionList().success(function(response){
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
           { name: 'cargo', displayName: 'Cargo Jefe' },
           { name: 'nombre', displayName: 'Nombre Jefe ' },
           { name: 'apellido', displayName: 'Apellido Jefe ' },
           { name: 'cargo', displayName: 'Cargo' },
           /*{ name: 'trabajador_id', displayName: 'Trabajador ID' },
           { name: 'area_id', displayName: 'Area ID' },*/
           /* { name: 'status', displayName: 'Estado',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row,col) == "Eliminado" ) {
                        return 'recognition_eliminado';
                };

                if (grid.getCellValue(row,col) == "Activo") {
                    return 'recognition_aprobado';
                }
                
            }}*/
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
