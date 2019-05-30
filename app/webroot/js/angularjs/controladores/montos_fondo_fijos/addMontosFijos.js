app.controller('controllerAddMontosFijos', ['$scope', '$http', '$filter', 'servicioMontosFijos', function($scope, $http, $filter, servicioMontosFijos) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
    $scope.cargador = loader;

    $scope.montofijo={};

    $scope.addMontosFijos=function(){
        //console.log($scope.montofijo);
        servicioMontosFijos.addMontos($scope.montofijo).success(function(data){
            window.location.href = host+"montos_fondo_fijos/view_lista_montos"
        });
    }

}]);
