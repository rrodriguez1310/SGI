app.controller('controllerSolicitudesViaticos', ['$scope', '$http', '$filter', 'solicitudesRendicionviaticos', function($scope, $http, $filter, solicitudesRendicionviaticos) {
    $scope.tablaDetalle = false;
    $scope.loader = false;
    $scope.cargador = loader;
    var i=1;
    var listaRendicion = [];
    $scope.rendicion = {};
    $scope.rendicionList = [];
    $scope.guardarRendicion = {};
    //$scope.formularioSolicitud = [];
    $scope.total = [];
    $scope.totalx = 0;
    $scope.documetosRendicion = [];
    $scope.totalGastos=[];

    $scope.documentos = false;

    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false, 
        enableSorting: true,
        enableColumnResizing: true,
        enableCellEdit: false,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.eliminarBtnGrilla = true;
                
            });
        }
    };

    $scope.deleteRow = function() {
        var r = confirm("Desea eliminar el registro!");
        if(r){
            var selectedRowEntities = $scope.gridApi.selection.getSelectedRows();
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                var rowIndexToDelete = $scope.gridOptions.data.indexOf(rowEntity);
                $scope.totalGastos = $scope.totalGastos - rowEntity.sub;
                $scope.gridOptions.data.splice(rowIndexToDelete, 1);
                $scope.sumaResta();
                $scope.eliminarBtnGrilla = false;
            })
        }
    };

    $scope.gridOptions.columnDefs = [
       // {name:'eliminar', displayName: '',cellTemplate: '<a href="#" ng-click="grid.appScope.deleteRow(row.entity)" ><span class="glyphicon glyphicon-trash"></span></a>'},
        {name:'descripcion', displayName: 'descripcion'},
        {name:'colaborador', displayName: 'Colaborador'},
        {name:'monto', displayName: 'Monto'},
        {name:'gerencia', displayName: 'Gerencia'},
        {name:'estadio', displayName: 'Estadio'},
        {name:'contenido', displayName: 'Contenido'},
        {name:'canales_distribucion', displayName: 'Canales de distrubucion'},
        {name:'otros', displayName: 'Otros'},
        {name:'proyectos', displayName: 'Proyectos'},
        {name:'codigo_presupuestario', displayName: 'Cod. presupuesto'}
    ];
  
    var sum = [];
    var totalx = [];
    
    $scope.submit = function() {
      
        var i =0;
        $("#myFormulario").find('select').each(function(v, e){
            if(e.value != ""){
                //console.log($('#'+e.id+" option[value="+e.value+"]").attr("selected","selected"));
            }
        });


        if($("#descripcion").val() == ""){
            $("[for=descripcion]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=descripcion]").text('');
            i = i + 1;
        }

        if($("#colaborador").val() == ""){
            $("[for=colaborador]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=colaborador]").text('');
            i = i + 1;
        }

        if($("#monto").val() == "" || $("#monto").val()==0){
            $("[for=monto]").text('Debe ingresar precio').css('color', 'red');
        }else{
            $("[for=monto]").text('');
            i = i + 1;
        }

        if($("#dimUno").val() == ''){
            $("[for=gerencia]").text('Campo obligatorio').css('color', 'red');
            
        }else{
            $("[for=gerencia]").text('');
            i = i + 1;
        }

        if($("#codigoPresupuestario").val() == ""){
            $("[for=presupuestos]").text('Campo obligatorio').css('color', 'red');
        }else{
            $("[for=presupuestos]").text('');
            i = i + 1;
        
        }

        if(i < 5){
            return false;
        }
      // console.log($scope.rendicion);
        var  largo = $scope.gridOptions.data.length;
       // $scope.total = eval(sum.join("+"))
        
        
        solicitudesRendicionviaticos.formularioRendicionFondoAdd($scope.rendicion).success(function(data){
            
            for(var i =0; i<data.length;i++){
                listaRendicion.push(data[i]);
            }
            
            
            listaRendicion.push(data);
            $scope.gridOptions.data = listaRendicion;
            /*$('#descripcion').val('')
            $('#colaborador').val('')
            $('#monto').val('')*/

            $scope.rendicion.descripcion='';
            $scope.rendicion.colaborador='';
            $scope.rendicion.monto='';

 
            $scope.sumaResta();
        }); 
        
        $("#ingresoProducto").modal('hide');
    };


   /* $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

        if(row.isSelected == true){
            if(row.entity.id){
                $scope.id = row.entity.id;
                $scope.eliminarBtn = true;
                $scope.boton = true;
            }
        }else{
            $scope.boton = false;
            row.entity.id.length = 0;
            $scope.id = '';
            $scope.eliminarBtn = false;
        }
        
    });*/

    $scope.guardaRendicionSubmit = function(){
    
        var i =0;
        //console.log($scope.guardarRendicion);
        if(Object.keys($scope.guardarRendicion).length ==0){
            alert('Todos los campos son obligatorios');
            $("[for=fecha_inicio]").text('Campo obligatorio').css('color', 'red');
            $("[for=fecha_termino]").text('Campo obligatorio').css('color', 'red');
            $("[for=responsable]").text('Campo obligatorio').css('color', 'red');
            $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            return false;
        }else{
            if($scope.guardarRendicion.fecha_inicio){
                $("[for=fecha_inicio]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_inicio]").text('Campo obligatorio').css('color', 'red'); 
            }

            if($scope.guardarRendicion.fecha_termino){
                $("[for=fecha_termino]").text('');
                i = i + 1;
            }else{
                $("[for=fecha_termino]").text('Campo obligatorio').css('color', 'red');
            }
     
            if($scope.guardarRendicion.responsable){
                $("[for=responsable]").text('');
                i = i + 1;
              
            }else{
                $("[for=responsable]").text('Campo obligatorio').css('color', 'red');
            }

            if($scope.guardarRendicion.titulo){
                $("[for=titulo]").text('');
                i = i + 1;
               
            }else{
                $("[for=titulo]").text('Campo obligatorio').css('color', 'red');
            }



           /* if(Object.keys($scope.documetosRendicion).length==0){
                $("[for=doc]").text('Debe ingresar documentos').css('color', 'red');
                //return false;
            }else{
                $("[for=doc]").text('');
                i = i + 1;
            }*/

            if(Object.keys(listaRendicion).length==0){
                $("[for=gridOptions]").text('Debe ingresar detalle de gastos').css('color', 'red');
                //return false;
            }else{
                $("[for=gridOptions]").text('');
                i = i + 1;
            }

            if(i <5){
                return false;
            }

        }   


      // console.log($scope.guardarRendicion);

       //return false;
        solicitudesRendicionviaticos.guardaRedicionFondos($scope.guardarRendicion, listaRendicion, $scope.documetosRendicion, Math.round($scope.totalGastos)).success(function(data){
            window.location.href = host+"solicitud_requerimiento_viaticos";
        });
    }
    
    
    
    $scope.shows=function(id){

        if( id==5 || id==7 ){
            $scope.eliminarBtn = true;
            $scope.documentos = false;
        }else{
            $scope.eliminarBtn = false;

            if(id==4){
                $scope.documentos = true;
            }else{
                $scope.documentos = false;
            }
            
        }
    }

    $scope.estado= function(id){


        //console.log(id);
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
            if($scope.datos.observacion!=undefined && $scope.datos.observacion!=""){
                $("[for=observacion]").text('');
            }else{
                $("[for=observacion]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            }
        }
        if($scope.documentos){
            if($scope.datos.documento!=undefined || $scope.datos.documento!=""){
                $("[for=documento]").text('');
            }else{
                $("[for=documento]").text('Campo obligatorio').css('color', 'red'); 
                return false;
            } 
        }
       // return false;
        solicitudesRendicionviaticos.actualizaEstado(id, $scope.datos.compra, $scope.datos.observacion,$scope.datos.documento).success(function(data){

            if($scope.datos.compra==4 || $scope.datos.compra==7){
                //console.log(host+"solicitudes_requerimientos/view_finanzas");
               window.location.href = host+"solicitud_requerimiento_viaticos/lista_finanza";
            }

            if($scope.datos.compra==1 || $scope.datos.compra==5){
                window.location.href = host+"solicitud_requerimiento_viaticos/lista_area";
            }
       });
    }

    $scope.sumaResta = function() {
        var sum = []; 
        var selectedRowEntities = $scope.gridOptions.data;
            angular.forEach(selectedRowEntities, function(rowEntity, key) {
                sum.push(rowEntity.monto.replace(/\./g,''))
            })

        var moneda = $("#moneda_observada").val();
           if(moneda!=''){
                $scope.totalGastos = (eval(sum.join("+")) * moneda);
            }else{
                $scope.totalGastos = eval(sum.join("+"));
            }
    }


    $scope.formatThusanNumber = function(){
        var num = $scope.rendicion.monto.replace(/\./g,'');
        if(!isNaN(num)){
            num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split('').reverse().join('').replace(/^[\.]/,'');
            //input.value = num;
            $("#monto").val(num);
        }
        else
        { 
            alert('Solo se permiten numeros');
            $("#monto").val($scope.rendicion.monto.replace(/[^\d\.]*/g,''));
        }
    }
}]);
