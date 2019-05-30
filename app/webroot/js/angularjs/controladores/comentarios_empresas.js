app.controller('ComentariosEmpresas',  ['$scope', '$http', '$filter', '$location', 'uiGridConstants', function ($scope, $http, $filter, $location, uiGridConstants) {
    $scope.loader = true
    $scope.cargador = loader;

    $scope.listaComentarios = function(idEmpresa){ 
        $http.get(host25+'companies_comentarios/lista_comentarios_json/'+idEmpresa).success(function(data) {
                //console.log(data);
                $scope.ComentariosEmpresas = data;     
                $scope.loader = false;
                //$scope.comentarios = true;
                //$scope.idEmpresa = idEmpresa;

                console.log('asdasdasd'+idEmpresa);
            });
    }

}]);
