app.controller('induccionPantallasController', ['$scope', '$http', '$filter', 'induccionPantallasService',  function($scope, $http, $filter, induccionPantallasService, $modal) {
    
    $scope.$watch('idTrabajador', function () {
        //console.log("$scope.idTrabajador", $scope.idTrabajador);
        induccionPantallasService.induccionList($scope.idTrabajador).success(function(response){
            //console.table(response);            
            $scope.records = response;
        });        
    });
    $scope.getLecciones = function(id) {
        $scope.leccion_id = id;

        if(id > 0){
            //verifica si exite la leccion, sino la guarda
            $scope.contenido_id = '';
            induccionPantallasService.getContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(data){
                //alert(data);
                if(data == 0){
                    induccionPantallasService.insertContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(dato){
                    //console.log(dato);
                });
                }else{
                    //console.log("El contenido fue terminado por el usuario1");
                }
            });

        }
    }
}]);
