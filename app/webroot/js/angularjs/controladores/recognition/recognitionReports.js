app.controller('reportsController', ['$scope', '$http', '$filter', 'reportsService', function($scope, $http, $filter, reportsService) {
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

    

    reportsService.recognitionList().success(function(response){
        //console.log(response);
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
           /* $scope.imagedir =row.entity.imagedir;
            if(row.isSelected == true){
                $scope.id = row.entity.trabajador_id; 
                $scope.boton = true;
            }else{
                $scope.boton = false;
                $scope.id = 0;
            }*/
            
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
           { name: 'fecha', displayName: 'Fecha' },
           { name: 'colaborador', displayName: 'Colaborador ' },
	   { name: 'categoria', displayName: 'Categoría ' },
           { name: 'producto', displayName: 'Producto ' },
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

}]);
