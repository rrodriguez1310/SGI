app.controller('controllerEstadosRendicion', ['$scope', '$http', '$filter', 'Flash', 'solicitudesRendicion', function($scope, $http, $filter, Flash, solicitudesRendicion) {
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.eliminarBtn = false;
    $scope.botonVer = false
    $scope.form=[];
    $scope.menuVista= true;

    $scope.shows=function(id){

        console.log(1,id);

        if(id==""){
            $scope.documentos = true;
        }

       
        if( id==5 || id==7 ){
            $scope.eliminarBtn = true;
            $scope.documentos = false;
        }else{
            $scope.eliminarBtn = false;
            if(id ==4 ){
                $scope.documentos = true;
            }
        }
    }

    $scope.estado= function(id){

       // console.log($scope.datos);

        if($scope.datos!=undefined){
            $("[for=compra]").text('');
        }else{
            $("[for=compra]").text('Campo obligatorio').css('color', 'red'); 
            return false;
        }

        if( $scope.datos.compra!=''){
            $("[for=compra]").text('');
        }else{
            $("[for=compra]").text('Campo obligatorio').css('color', 'red'); 
            return false;
        }

        if($scope.eliminarBtn){
            if($scope.datos.observacion!=undefined){
                $("[for=observacion]").text('');
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            }
        }

    
        solicitudesRendicion.actualizaEstado(id, $scope.datos.compra, $scope.datos.observacion ).success(function(data){

            if($scope.datos.compra==4 || $scope.datos.compra==7){
                //console.log(host+"solicitudes_requerimientos/view_finanzas");
               window.location.href = host+"solicitudes_requerimientos/view_rendicion_finanzas";
            }

            if($scope.datos.compra==1 || $scope.datos.compra==5){
                window.location.href = host+"solicitudes_requerimientos/view_rendicion_area";
            }
       });
    }

    
}]);