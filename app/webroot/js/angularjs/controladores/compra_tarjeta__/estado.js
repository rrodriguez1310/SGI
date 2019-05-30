app.controller('controllerEstado', ['$scope', '$http', '$filter', 'Flash', 'compraTarjeta', function($scope, $http, $filter, Flash, compraTarjeta) {
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.eliminarBtn = false;
    $scope.botonVer = false
    $scope.form=[];
    $scope.menuVista= true;
    
    $scope.estado= function(id){

       // alert('Hola'+angular.element('#tarjeta_estado_id').val());

        if(angular.element('#tarjeta_estado_id').val()==''){
            $("[for=compra]").text('Campo obligatorio').css('color', 'red');
            return false;
        }

        if(idEstado == undefined){
		    var	idEstado = angular.element('#tarjeta_estado_id').val();
		}

		if(idEstadoCompra == undefined){
		    var	idEstadoCompra = angular.element('#tarjeta_estado_id').val();
        }
        
      //  alert(idEstado);

        if( idEstado == 5 || idEstado == 6 || idEstado == 7 ){
            if($scope.observacion  == ''){
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red');
                return false;
            }else{
                $("[for=observacion]").text('');
            }
        }

        compraTarjeta.estadoSolicitudCompra(id, idEstado ,idEstadoCompra ,$scope.observacion ).success(function(datax){
            Flash.create("success", "Cambio de estado", 'customAlert');
              if( idEstado == 1 || idEstado == 5 ){
                angular.element('#area').find('span').trigger('click');
              }
      
              if( idEstado == 4 || idEstado == 7 ||  idEstadoCompra == 8 ||  idEstadoCompra == 9){
                 angular.element('#finanzas').find('span').trigger('click');
              }
      
              if( idEstado == 2 || idEstado == 6 ){
                 angular.element('#gerente').find('span').trigger('click');
              }
        });
    }

    $scope.respuesta= function(id){
        compraTarjeta.estadoRespuesta(id).success(function(data){

            if(data.datax.codigo==9){
                $('#tarjeta_estado_id option[value = "4"]').attr("selected", true);
                $('#compra option[value = "9"]').attr("selected", true);
                $scope.compraBtn=true;
            }else{
                $('#tarjeta_estado_id option[value = "'+data.datax.codigo+'"]').attr("selected", true)
            }
        });
    }
    
    $scope.muestraCampo= function(idEstado){

        if(idEstado == 4){
            $scope.compraBtn=true
        }

        if(idEstado == 5){
            $scope.eliminarBtn = true;
        }else if(idEstado == 6){
            $scope.eliminarBtn = true;
        }else if(idEstado == 7){
            $scope.eliminarBtn = true;
            $scope.compraBtn=false;
        }else{
            $scope.eliminarBtn = false;
        }  
    }
}]);
