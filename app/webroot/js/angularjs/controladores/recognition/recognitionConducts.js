app.controller('recognitionConducts', ['$scope', '$http', '$filter', 'conductsService', function($scope, $http, $filter, conductsService) {
    $scope.id = 0;
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

    

    conductsService.recognitionList().success(function(response){
    console.log(response);
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
            $scope.imagedir =row.entity.imagedir;
            if(row.isSelected == true){
                $scope.id = row.entity.id;
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
            { name: 'name', displayName: 'Nombre' },
            { name: 'descrption', displayName: 'Descripción' },
            { name: 'imagen', displayName: 'Imagen',
                cellTemplate: '<div class="text-center"> <a target="_blank" href="'+host+'app/webroot/files/recognition_conduct/image/{{row.entity.imagedir}}/vga_{{row.entity.image}}"><img style="padding:2px; lefth:10px;" ng-src="'+host+'app/webroot/files/recognition_conduct/image/{{row.entity.imagedir}}/thumb_{{row.entity.image}}"/></a>   </div>'},
            { name: 'status', displayName: 'Estado',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row,col) == "Eliminado" ) {
                        return 'recognition_eliminado';
                };
 
                if (grid.getCellValue(row,col) == "Activo") {
                    return 'recognition_aprobado';
                }
                
            }}
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
        window.location.href = host + "recognitionConducts/delete/" + $scope.id
    };

}]);
