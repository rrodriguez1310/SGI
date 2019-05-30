app.controller('collaboratorProductsController', ['$scope', '$http', '$filter', 'collaboratorProductsService', function($scope, $http, $filter, collaboratorProductsService) {
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

    collaboratorProductsService.recognitionList().success(function(response){
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
            { name: 'points', displayName: 'Puntos' },
            //{ name: 'quantity', displayName: 'Disponible' },
            { name: 'imagen', displayName: 'Detalle',
                cellTemplate: '<div class="text-center"> <a href="'+host+'recognitionProducts/detalle/{{row.entity.id}}"><img style="padding:2px; lefth:10px;" ng-src="'+host+'app/webroot/files/recognition_product/image/{{row.entity.imagedir}}/thumb_{{row.entity.image}}" alt="Sin imagen"> </a> </div>'},
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

    //confirma el canje de puntos x producto
    $scope.confirmacion = function() {
        window.location.href = host + "recognitionCollaborators/canje/" + $scope.id
    };

}]);
