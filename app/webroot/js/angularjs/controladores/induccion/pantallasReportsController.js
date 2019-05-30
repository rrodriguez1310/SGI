app.controller('reportsController', ['$scope', '$http', '$filter', 'induccionPantallasService',  function($scope, $http, $filter, induccionPantallasService, $modal) {
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

    $scope.gridOptions = {
        columnDefs: [
            { name: 'nombre', displayName: 'Nombre' },
            { name: 'cargo', displayName: 'Cargo' },
            { name: 'gerencia', displayName: 'Gerencia' },
            { name: 'etapa', displayName: 'Lección'},
            { name: 'leccionTermin', displayName: 'Estado Lección',
                cellTemplate: '<div ng-if="row.entity.leccionTermin > 0" >Finalizado</div>  <div ng-if="row.entity.leccionTermin < 1  "> En Progreso </div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row,col) == "0" ) {
                        return 'recognition_eliminado';
                };

                if (grid.getCellValue(row,col) == "1") {
                    return 'recognition_aprobado';
                }
                
            }},
            { name: 'quizTermin', displayName: 'Estado Quiz',
                cellTemplate: '<div ng-if="row.entity.quizTermin == 2" >No Aplica</div>  <div ng-if="row.entity.quizTermin == 1 "> Aprobado </div> <div ng-if="row.entity.quizTermin == 0 "> Pendiente </div>',
                cellClass: function(grid, row, col, rowRenderIndex, colRenderIndex) {
                if (grid.getCellValue(row,col) == "0" ) {
                        return 'incorrecta';
                };

                if (grid.getCellValue(row,col) == "2" ) {
                    return 'noAplica';
                };

                if (grid.getCellValue(row,col) == "1") {
                    return 'correcta';
                }
                
            }},
            { name: 'puntos', displayName: 'Puntuación'}
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

    induccionPantallasService.induccionReports().success(function(response){
        //console.log($scope.induccionPantallasService);
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
            $scope.imagedir = row.entity.imagedir;
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

}]);
