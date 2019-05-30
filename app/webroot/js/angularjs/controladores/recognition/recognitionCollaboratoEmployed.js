app.controller('recognitionCollaboratorController', ['$scope', '$http', '$filter', 'recognitionCollaboratorService', function($scope, $http, $filter, recognitionCollaboratorService) {
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

    recognitionCollaboratorService.recognitionList().success(function(response){
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
           { name: 'fecha', displayName: 'Fecha' },
           { name: 'cambio', displayName: 'Tipo de Movimiento:',
           cellTemplate: '<div ng-if="row.entity.cambio > 0" >Canje</div>  <div ng-if="row.entity.cambio < 1"> Reconocimiento </div>' },
           { name: 'descripciondd', displayName: 'Descripción',
           cellTemplate: '<div ng-if="row.entity.cambio > 0" >{{row.entity.producto}}</div>  <div ng-if="row.entity.cambio == 0"> {{row.entity.subconduta}}</div>' },
           { name: 'ingresos', displayName: 'Puntos Asignados'},
           { name: 'egresos', displayName: 'Puntos Canjeados' },
          /* { name: 'imagen', displayName: 'Imagen',
           cellTemplate: '<div ng-if="row.entity.product_id > 0" class="text-center"> <a href="'+host+'recognitionProducts/canje/{{row.entity.product_id}}"><img style="padding:2px; lefth:10px;" ng-src="'+host+'app/webroot/files/recognition_product/image/{{row.entity.imagedir}}/thumb_{{row.entity.image}}" alt="Producto sin imagen"></a></div>  <div class="text-center"><img style="padding:2px; lefth:10px;" ng-src="'+host+'app/webroot/img/thumb_sin_imagen.jpeg" alt="xxx"></div>'},*/
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