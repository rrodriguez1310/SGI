app.controller('recognitionCollaborator', ['$scope', '$http', '$filter', 'recognitionCollaborator', function($scope, $http, $filter, recognitionCollaborator) {
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

    $scope.gridOptions = {
        columnDefs: [
           { name: 'id', displayName: 'ID', visible: false },
           { name: 'nombre', displayName: 'Nombre' },
           { name: 'apellido', displayName: 'Apellido' },
           { name: 'cargo', displayName: 'Cargo'},
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

    recognitionCollaborator.recognitionList().success(function(response){
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 
            $scope.imagedir =row.entity.imagedir;
            if(row.isSelected == true){
                $scope.id = row.entity.id;
                $scope.boton = true;
                console.log($scope.boton);
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

    $scope.confirmacion = function() {
        window.location.href = host + "recognitionCollaborators/delete/" + $scope.id
    };
}]);