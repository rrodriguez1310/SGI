app.controller('Dimensiones', ['$scope', '$http', '$filter', '$location', 'uiGridConstants', function ($scope, $http, $filter, $location, uiGridConstants) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.gridOptions = {  
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'Id', displayName:'Id'},
        {name:'TiposDimensioneId', displayName:'TiposDimensioneId', visible: false},
        {name:'NombreTipoDimension', displayName:'nombre'},
        {name:'descripcionTipoDimension', displayName:'Descripción'},
        {name:'Codigo', displayName:'Codigo'},
        {name:'Nombre', displayName:'Nombre'},
        {name:'Descripcion', displayName:'Descripcion'},
        {name:'CodigoCorto', displayName:'Codigo Corto'},
    ];

    $http.get(host25+'dimensiones/json_listar_dimensiones/').success(function(data) {
        $scope.gridOptions.data = data; 
        $scope.loader = false;
        $scope.tablaDetalle = true;
        
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isNumber(row.entity.Id))
            {
                $scope.id = row.entity.Id;
            }

            if(row.isSelected == true)
            {
                $scope.boton = true;
            }
            else
            {
                $scope.boton = false;
                $scope.id = "";
            }
        });
        
        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };

        $scope.confirmacion = function(text) {
            $scope.locationAbsUrl = $location.absUrl();
            window.location.href = $scope.locationAbsUrl+"/delete/"+$scope.id
        };
    });
}]);
