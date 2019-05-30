app.controller('controllerEstados', ['$scope', '$http', '$filter', 'Flash', 'solicitudesRequerimiento', function($scope, $http, $filter, Flash, solicitudesRequerimiento) {
    $scope.tablaDetalle = false;
    $scope.loader = false
    $scope.cargador = loader;
    $scope.eliminarBtn = false;
    $scope.botonVer = false
    $scope.form=[];
    $scope.menuVista= true;
    $scope.datos;
    $scope.documento = false;

    $scope.show=function(id){
        if(id==''){
            $scope.documento = false;
        }
        if( id==5 || id==7 ){
            $scope.eliminarBtn = true;
            $scope.documento = false;
        }else {
           
            $scope.eliminarBtn = false;
            if(id==4 ){
                $scope.documento = true;
            }
        }
    }
    
    $scope.estado= function(id){
        //console.log("11", $scope.datos.compra);
        
        if($scope.datos != undefined){
            $("[for=compra]").text('');
         
        }else{
            $("[for=compra]").text('Campo obligatorio').css('color', 'red'); 
            return false;
        }

        if($scope.datos != undefined){

            if( $scope.datos.compra!=""){
                $("[for=compra]").text('');
            }else{
                $("[for=compra]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            }

        }


        if($scope.documento){
      
            if($scope.datos.n_documento != undefined && $scope.datos.n_documento !=''){
                $("[for=n_documento]").text('');
            }else{
                $("[for=n_documento]").text('Campo obligatorio n° cheque').css('color', 'red'); 
                //alert('Entrado 2')
                return false;
            }
        }

        if($scope.eliminarBtn){
            if($scope.datos.observacion!=undefined && $scope.datos.observacion != "" ){
                $("[for=observacion]").text('');
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red'); 
               // alert('Entrado 3')
                return false;
            }
        }
       // return false
        solicitudesRequerimiento.actualizaEstado(id, $scope.datos.compra, $scope.datos.observacion, $scope.datos.n_documento).success(function(data){

           if($scope.datos.compra==4 || $scope.datos.compra==7){
                //console.log(host+"solicitudes_requerimientos/view_finanzas");
                 window.location.href = host+"solicitudes_requerimientos/view_finanzas";
            }

            if($scope.datos.compra==1 || $scope.datos.compra==5){
               window.location.href = host+"solicitudes_requerimientos/view_area";
            }
        });
    }

    
}]);
