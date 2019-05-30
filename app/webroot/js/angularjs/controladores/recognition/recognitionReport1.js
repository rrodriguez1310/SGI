app.controller('recognitionReport', ['$scope', '$http', '$filter', 'recognitionReportService',  function($scope, $http, $filter, recognitionReportService, $modal) {

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
            { name: 'jefe', displayName: 'Nombre Jefe' },
            { name: 'colaborador', displayName: 'Nombre Colaborador' },
            { name: 'fecha', displayName: 'Fecha' },
            { name: 'conducta', displayName: 'Valores'},
            { name: 'subconducta', displayName: 'Comportamientos'},
            { name: 'puntosadd', displayName: 'Puntos Asignados'}
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

    recognitionReportService.recognitionList().success(function(response){
    //console.log(response);
        $scope.gridOptions.data = response;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){ 

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
