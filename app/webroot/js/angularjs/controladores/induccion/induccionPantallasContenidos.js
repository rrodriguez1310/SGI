app.controller('induccionPantallasContenidos', ['$scope', '$http', '$filter', '$location', 'induccionPantallasService',  function($scope, $http, $filter, $location, induccionPantallasService, ) {
    var leccion_id = $location.absUrl().split('/');
    corte = leccion_id.length -1;
    //console.log(corte);

    $scope.siguiente = 1;
    $scope.anterior = 1;

    $scope.$watch('idTrabajador', function () {
        induccionPantallasService.getContenidosLeccion(leccion_id[corte]).success(function(response1){

            var response = response1;

            var options = [];
            $scope.count = 0;

            $scope.leccion_id = response[0]['etapa_id']; 
            $scope.contenido_id = response[0]['id'];
            $scope.quiz = 0;
            $scope.contadorJson = 0;
            //$scope.quiz = response[0]['quiz'];
            //$scope.quiz = response[response.length-1]['quiz'];


            $scope.myFunc = function(val) {
                if(val < $scope.contadorJson){
        
                    $scope.leccion_id = response[val]['etapa_id'];
                    $scope.contenido_id = response[val]['id'];
                    if(val == $scope.contadorJson-1){
                        $scope.quiz = response[val]['quiz'];
                    }else{
                        $scope.quiz = 0;
                    }
                    
                    induccionPantallasService.getContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(data){
                        //console.log(data + "aqui");
                        if(data == 0){
                            induccionPantallasService.insertContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(dato){
                                //console.log("registro guardado");
                            });
                        }else{
                        // console.log("El contenido fue terminado por el usuario");
                        }
                    });
        
                    $scope.myObj = options[val];
                    $scope.count++;
                    
                    if($scope.quiz == 1){
                        $scope.siguiente = 0;
                    }
        
                }else{
                    //alert("ultima lamina");
                    window.location.href = host + "induccionPantallas";
                }
            };
        
            $scope.myFunc2 = function(val) {
                if(val >= 0){
                    //console.log(val);
                    $scope.contenido_id = response[val]['id'];
                    //$scope.quiz = response[val]['quiz'];
        
                    if(val < $scope.contadorJson-1){
        
                        $scope.quiz = 0;
                    }else{
                        $scope.quiz = 1;
                    }
                    $scope.myObj = options[val];
                    $scope.count--;
        
                    if($scope.quiz == 0){
                        $scope.siguiente = 1;
                    }
                }else{
                    //alert("primera lamina");
                }
            };


        
            induccionPantallasService.getContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(data){
                //console.log(data);
                if(data == 0){
                    induccionPantallasService.insertContenidosProgreso( $scope.leccion_id,  $scope.contenido_id, $scope.idTrabajador).success(function(dato){
                        //console.log(dato);
                    });
                }else{
                    //console.log("El contenido fue terminado por el usuario");
                }
            });

            for (var i = 0; i < response.length; i++) {
                options.push({
                    "margin-top": "25px",
                    "height": "600px",
                    "width": "1140px",
                    "titulo": response[i]['titulo'],
                    "descripcion": response[i]['descripcion'],
                    "background-color": "white",
                    "background-repeat": "no-repeat",
                    "padding": "50px ",
                    "background-size": "1140px 600px",
                    "background-image": "url('"+host+'app/webroot/files/induccion_contenido/image/'+response[i]['imagedir']+'/'+response[i]['image']+"')"
                })  
                //console.log(response[i]['descripcion']);
            }

            $scope.myObj = options[$scope.count];
            //console.log($scope.myObj);
            $scope.contadorJson = options.length;
            if($scope.contadorJson == 1 && response[0]['quiz'] == 1){
                $scope.quiz = 1;
                $scope.siguiente = 0;
            }                            
        
        }); 
    });



    



}]);
